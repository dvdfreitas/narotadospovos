<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Services\IfThenPay\MbWayUnavailableException;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Console\Command;

/**
 * Resolve os pagamentos MB Way cuja notificação não chegou.
 *
 * A notificação da ifthenpay é enviada uma só vez: se o servidor estiver em
 * baixo nesse segundo, perde-se e ninguém repete. Este comando é a rede.
 *
 * É um comando e não um job para correr dentro do próprio agendador, sem fila
 * nem trabalhador pelo meio — menos uma peça a poder falhar em silêncio. E
 * pode ser corrido à mão, que é o que permite distinguir um problema de
 * código de um problema de agendamento.
 *
 * Desenho e estados: documentation/mbway-plan.md
 */
class CheckPendingMbWayPayments extends Command
{
    protected $signature = 'mbway:check-pending';

    protected $description = 'Resolve pagamentos MB Way cuja notificação não chegou';

    public function handle(CheckMbWayPayment $check): int
    {
        $pending = Payment::query()
            // requested é o único estado que vale a pena consultar: os finais
            // já acabaram, e os unknown não têm RequestId para perguntar —
            // esses só se resolvem pela notificação ou pela reconciliação.
            ->where('status', Payment::STATUS_REQUESTED)
            // Enquanto os 4 minutos não passam, quem vigia é o ecrã do
            // comprador. Aqui só interessam os que já deviam ter terminado.
            ->where('expires_at', '<', now())
            ->get();

        foreach ($pending as $payment) {
            try {
                $check->check($payment);
                $this->line("{$payment->reference}: {$payment->fresh()->status}");
            } catch (MbWayUnavailableException $e) {
                // Uma consulta falhada não deixa nada por resolver: o
                // pagamento fica onde está e o ciclo seguinte tenta de novo.
                // Deixar a excepção subir pararia os restantes.
                $this->warn("{$payment->reference}: {$e->getMessage()}");
            }
        }

        $this->info("{$pending->count()} pagamento(s) verificado(s).");

        return self::SUCCESS;
    }
}
