<?php

namespace App\Jobs;

use App\Models\Payment;
use App\Services\IfThenPay\MbWayUnavailableException;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Support\Facades\Log;

/**
 * Resolve os pagamentos cuja notificação não chegou.
 *
 * A notificação da ifthenpay é enviada uma só vez: se o servidor estiver em
 * baixo nesse segundo, perde-se e ninguém repete. Este job é a rede.
 *
 * Desenho e estados: documentation/mbway-plan.md
 */
class CheckPendingMbWayPayments
{
    public function handle(CheckMbWayPayment $check): void
    {
        Payment::query()
            // requested é o único estado que vale a pena consultar: os finais
            // já acabaram, e os unknown não têm RequestId para perguntar —
            // esses só se resolvem pela notificação ou pela reconciliação.
            ->where('status', Payment::STATUS_REQUESTED)
            // Enquanto os 4 minutos não passam, quem vigia é o ecrã do
            // comprador. O job só se interessa pelos que já deviam ter
            // terminado e não terminaram.
            ->where('expires_at', '<', now())
            ->each(function (Payment $payment) use ($check) {
                try {
                    $check->check($payment);
                } catch (MbWayUnavailableException $e) {
                    // Uma consulta falhada não deixa nada por resolver: o
                    // pagamento fica onde está e o ciclo seguinte tenta de
                    // novo. Deixar a excepção subir pararia os restantes.
                    Log::warning('Consulta de estado MB Way falhou', [
                        'payment_id' => $payment->id,
                        'reference'  => $payment->reference,
                        'erro'       => $e->getMessage(),
                    ]);
                }
            });
    }
}
