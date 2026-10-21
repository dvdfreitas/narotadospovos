<?php

namespace App\Services\IfThenPay;

/**
 * Um MB Way que não sai do servidor, para experimentar a loja sem pagar.
 *
 * Liga-se com IFTHENPAY_FAKE=true e nunca em produção — ver
 * AppServiceProvider::register(). Tudo o resto corre a sério: a encomenda,
 * o pagamento, o ecrã de espera, o email, a lista pública e o admin. Só
 * esta classe finge ser a ifthenpay.
 *
 * O resultado escolhe-se pelo último dígito do telemóvel:
 *
 *   …1  o cliente recusa na app             (020 → rejected)
 *   …2  o cliente não responde a tempo      (101 → expired)
 *   …3  a ifthenpay recusa criar o pedido   (999 → failed)
 *   …4  a ifthenpay não responde            (timeout → unknown)
 *   outro  paga                             (000 → paid)
 *
 * Os desfechos de 1, 2 e qualquer outro só chegam passados DELAY segundos,
 * para se ver o ecrã de espera. Até lá a consulta responde "Pending".
 */
class FakeMbWayClient extends MbWayClient
{
    /** Quanto tempo o "cliente" demora a decidir na app. */
    private const DELAY = 8;

    public function __construct()
    {
        parent::__construct('FAKE');
    }

    public function requestPayment(
        string $orderId,
        string $amount,
        string $mobileNumber,
        string $description,
        ?string $email = null,
        ?string $notificationUrl = null,
    ): MbWayRequestResult {
        $scenario = substr($mobileNumber, -1);

        return match ($scenario) {
            '3' => new MbWayRequestResult('999', 'Simulado: erro ao iniciar', null),
            '4' => throw new MbWayUnavailableException('Simulado: a ifthenpay não respondeu'),
            // O cenário e a hora vão no próprio RequestId: assim a consulta
            // sabe o que responder sem guardar nada em lado nenhum.
            default => new MbWayRequestResult('000', 'Simulado: pending acceptance', "FAKE-{$scenario}-" . time()),
        };
    }

    public function checkStatus(string $requestId): MbWayStatusResult
    {
        [, $scenario, $requestedAt] = explode('-', $requestId) + [null, null, 0];

        if (time() - (int) $requestedAt < self::DELAY) {
            return new MbWayStatusResult('123', 'Simulado: Pending');
        }

        return match ($scenario) {
            '1'     => new MbWayStatusResult('020', 'Simulado: Declined'),
            '2'     => new MbWayStatusResult('101', 'Simulado: Expired'),
            default => new MbWayStatusResult('000', 'Simulado: Success'),
        };
    }
}
