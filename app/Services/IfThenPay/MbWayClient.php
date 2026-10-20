<?php

namespace App\Services\IfThenPay;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

/**
 * Cliente HTTP da API MB Way da ifthenpay.
 *
 * Recebe valores e devolve valores: não conhece encomendas, pagamentos
 * nem base de dados. Concentra num único ficheiro tudo o que depende
 * do fornecedor, e é testável isoladamente.
 *
 * Campos, limites e códigos: documentation/ifthenpay.md
 */
class MbWayClient
{
    /**
     * Servidor base da API REST v2.
     * Os caminhos /mbway e /mbway/status juntam-se a este endereço.
     *
     * Constante e não configuração: faz parte do contrato da API
     * e não varia entre ambientes.
     */
    private const BASE_URL = 'https://api.ifthenpay.com/spg/payment';

    /**
     * A chave identifica a conta ifthenpay em cada pedido.
     *
     * Recebida por construtor em vez de lida da configuração: quem
     * constrói decide a origem (AppServiceProvider::register), e os
     * testes passam uma chave própria sem tocar no .env.
     *
     * readonly porque a chave não muda durante a vida do objecto.
     */
    public function __construct(
        private readonly string $mbWayKey,
    ) {}

    /**
     * Pede à ifthenpay que envie uma notificação de pagamento ao telemóvel.
     *
     * O telemóvel entra em formato nacional ("912345678"): o indicativo e o
     * formato que a API exige são tratados aqui dentro. O mesmo vale para os
     * nomes dos campos e para os códigos de estado — nada disso sai desta classe.
     *
     * O valor entra como texto com duas casas ("5.00"), tal como o cast
     * decimal:2 o entrega, para não passar por vírgula flutuante.
     *
     * Limites dos campos: documentation/ifthenpay.md
     */
    public function requestPayment(
        string $orderId,
        string $amount,
        string $mobileNumber,
        string $description,
        ?string $email = null,
        ?string $notificationUrl = null,
    ): MbWayRequestResult {
        // Identificadores rebentam, nunca truncam: um orderId cortado seria
        // enviado diferente do que está gravado, e o callback deixaria de
        // encontrar o pagamento. A garantia real está no varchar(15) da
        // coluna payments.reference — isto é a rede.
        if (strlen($orderId) > 15) {
            throw new InvalidArgumentException("orderId excede 15 caracteres: {$orderId}");
        }

        $payload = [
            'mbWayKey'     => $this->mbWayKey,
            'orderId'      => $orderId,
            'amount'       => $amount,
            'mobileNumber' => '351#' . $mobileNumber,
            // Texto decorativo mostrado na app: truncar é preferível a
            // recusar um pagamento. mb_substr conta caracteres, não bytes.
            'description'  => mb_substr($description, 0, 100),
        ];

        // Só entra se existir: 'email' => null diria que o email é nulo,
        // em vez de dizer que não há email.
        if ($email !== null) {
            $payload['email'] = $email;
        }

        // Endereço para onde a ifthenpay envia o estado final do pagamento.
        // Enviado por pedido, o que dispensa configurar o callback no
        // backoffice. Máximo de 500 caracteres, pela especificação.
        if ($notificationUrl !== null) {
            $payload['notificationUrl'] = mb_substr($notificationUrl, 0, 500);
        }

        // Só a falha de ligação é apanhada. Um erro de programação passa
        // por aqui sem ser tocado e rebenta como deve.
        // previous: guarda a causa original para os logs.
        try {
            $response = Http::timeout(10)
                ->post(self::BASE_URL . '/mbway', $payload);
        } catch (ConnectionException $e) {
            throw new MbWayUnavailableException($e->getMessage(), previous: $e);
        }

        // A API sinaliza as suas próprias recusas dentro de um HTTP 200
        // (Status 999). Logo, uma resposta que não seja 2xx veio de outra
        // coisa — proxy, firewall, manutenção — e não sabemos o que essa
        // coisa fez com o pedido antes de responder. Mesmo tratamento do
        // timeout: não é recusa, é "não sei".
        if (! $response->successful()) {
            throw new MbWayUnavailableException(
                "A ifthenpay respondeu HTTP {$response->status()}"
            );
        }

        return MbWayRequestResult::fromResponse($response->json());
    }

    /**
     * Pergunta à ifthenpay o que aconteceu a um pedido.
     *
     * É esta chamada que decide se o dinheiro entrou. A notificação avisa;
     * esta confirma.
     *
     * Os parâmetros vão na query string, não no corpo — é o que a
     * especificação define para este endereço.
     */
    public function checkStatus(string $requestId): MbWayStatusResult
    {
        try {
            $response = Http::timeout(10)->get(self::BASE_URL . '/mbway/status', [
                'mbWayKey'  => $this->mbWayKey,
                'requestId' => $requestId,
            ]);
        } catch (ConnectionException $e) {
            throw new MbWayUnavailableException($e->getMessage(), previous: $e);
        }

        // Ao contrário do pedido, uma consulta falhada não deixa nada por
        // resolver: nada mudou de estado, basta perguntar outra vez.
        if (! $response->successful()) {
            throw new MbWayUnavailableException(
                "A ifthenpay respondeu HTTP {$response->status()}"
            );
        }

        return MbWayStatusResult::fromResponse($response->json());
    }
}
