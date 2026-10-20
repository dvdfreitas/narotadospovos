<?php

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
 * segundos, e na maioria das vezes não encontra nada para fazer.
 *
 * Schedule::command e não Schedule::job: o comando corre dentro do próprio
 * agendador, sem fila nem trabalhador pelo meio.
 *
 * withoutOverlapping: se uma passagem demorar mais de um minuto, a seguinte
 * não arranca por cima — evita consultar o mesmo pagamento duas vezes.
 *
 * appendOutputTo: cada linha do ficheiro é um pagamento que a notificação não
 * resolveu e o polling apanhou. Para um sistema que mexe em dinheiro, esse
 * registo vale o espaço que ocupa.
 *
 * ATENÇÃO: só corre se o servidor tiver o agendador no cron. Sem essa
 * entrada, nada corre e ninguém avisa. Ver documentation/backlog.md
 */
Schedule::command('mbway:check-pending')
    ->everyMinute()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/mbway.log'));
