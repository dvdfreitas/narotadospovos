<?php

namespace App\Services\IfThenPay;

/**
 * Um MB Way que não sai do servidor, para experimentar o bazar sem pagar.
 *
 * Liga-se com IFTHENPAY_ENV=fake e nunca em produção — ver
 * AppServiceProvider::register(). Tudo o resto corre a sério: a encomenda,
 * o pagamento, o ecrã de espera, o email, a lista pública e o admin. Só
 * esta classe finge ser a ifthenpay.
 *
 * Qualquer telemóvel paga. Os outros desfechos pedem um número de teste
 * — 91, 92, 93 ou 96, seis zeros e o dígito do caso — que ninguém escreve
 * por engano. Com o último dígito apenas, um número verdadeiro acabado em
 * 1 a 4 caía num desfecho de falha sem se perceber porquê.
 *
 *   910000001  o cliente recusa na app             (020 → rejected)
 *   910000002  o cliente não responde a tempo      (101 → expired)
 *   910000003  a ifthenpay recusa criar o pedido   (999 → failed)
 *   910000004  a ifthenpay não responde            (timeout → unknown)
 *   outro      paga                                (000 → paid)
 *
 * Os desfechos pago, recusado e expirado só chegam passados DELAY
 * segundos, para se ver o ecrã de espera. Até lá a consulta responde
 * "Pending".
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
        $scenario = preg_match('/^9[1236]0{6}([1-4])$/', $mobileNumber, $match) ? $match[1] : 'pago';

        return match ($scenario) {
            '3' => new MbWayRequestResult('999', 'Simulado: erro ao iniciar', null),
            '4' => throw new MbWayUnavailableException('Simulado: a ifthenpay não respondeu'),
            // O cenário e a hora vão no próprio RequestId: assim a consulta
            // sabe o que responder sem guardar nada em lado nenhum.
            default => new MbWayRequestResult('000', 'Simulado: pending acceptance', "FAKE-{$scenario}-" . now()->timestamp),
        };
    }

    public function checkStatus(string $requestId): MbWayStatusResult
    {
        [, $scenario, $requestedAt] = explode('-', $requestId) + [null, null, 0];

        if (now()->timestamp - (int) $requestedAt < self::DELAY) {
            return new MbWayStatusResult('123', 'Simulado: Pending');
        }

        return match ($scenario) {
            '1'     => new MbWayStatusResult('020', 'Simulado: Declined'),
            '2'     => new MbWayStatusResult('101', 'Simulado: Expired'),
            default => new MbWayStatusResult('000', 'Simulado: Success'),
        };
    }
}
