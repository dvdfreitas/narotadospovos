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


/**
 * Processa a fila — emails de confirmação, sobretudo.
 *
 * --stop-when-empty: faz o que há e termina. Não fica um processo vivo, o que
 * seria impossível no alojamento partilhado.
 * --max-time=50: desiste antes do minuto seguinte, para não se sobrepor.
 * --tries=3: um email que falhe é tentado mais duas vezes; depois vai para a
 * tabela failed_jobs, onde pode ser visto e reenviado.
 *
 * Exige QUEUE_CONNECTION=database no .env. Com sync os trabalhos correm de
 * imediato, dentro do pedido, e esta linha não serve de nada.
 */
Schedule::command('queue:work --stop-when-empty --max-time=50 --tries=3')
    ->everyMinute()
    ->withoutOverlapping();
