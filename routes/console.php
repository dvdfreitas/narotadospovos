<?php

use App\Jobs\CheckPendingMbWayPayments;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

/**
 * Resolve os pagamentos MB Way cuja notificação não chegou.
 *
 * De minuto a minuto: um pagamento perdido fica resolvido em menos de 60
 * segundos, e na maioria das vezes a consulta não encontra nada para fazer.
 *
 * withoutOverlapping: se uma passagem demorar mais de um minuto, a seguinte
 * não arranca por cima — evita consultar o mesmo pagamento duas vezes.
 *
 * ATENÇÃO: isto só corre se o servidor tiver o agendador do Laravel no cron.
 * Sem essa entrada, o job nunca corre e ninguém avisa.
 * Ver documentation/backlog.md
 */
Schedule::job(new CheckPendingMbWayPayments)
    ->everyMinute()
    ->withoutOverlapping();
