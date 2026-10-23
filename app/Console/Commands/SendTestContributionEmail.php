<?php

namespace App\Console\Commands;

use App\Mail\ContributionConfirmed;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

/**
 * Envia o email de confirmação a um endereço à escolha, sem comprar nada.
 *
 * Serve para confirmar que o SMTP está bem configurado — em qualquer
 * ambiente, produção incluída: não grava nada nem mexe em encomendas. O
 * assunto leva [Teste].
 *
 * Envia já, sem passar pela fila. Um erro de autenticação aparece aqui no
 * terminal, em vez de ficar à espera num job.
 */
class SendTestContributionEmail extends Command
{
    protected $signature = 'bazar:testar-email
        {para : Endereço que recebe o email}
        {--encomenda= : Usar os dados de uma encomenda paga, pelo id, em vez do exemplo}';

    protected $description = 'Envia um email de confirmação de teste, sem compra';

    public function handle(): int
    {
        $to = $this->argument('para');

        if (Validator::make(['to' => $to], ['to' => 'email'])->fails()) {
            $this->error("Não parece um email: {$to}");

            return self::FAILURE;
        }

        $mail = ContributionConfirmed::example();

        if ($id = $this->option('encomenda')) {
            $order = Order::paid()->with('items')->find($id);
            $payment = $order?->payments()->where('status', 'paid')->latest('id')->first();

            if (! $order || ! $payment) {
                $this->error("Não há encomenda paga com o id {$id}.");

                return self::FAILURE;
            }

            $mail = new ContributionConfirmed($order, $payment, isTest: true);
        }

        $from = config('mail.from.address');
        $this->line("De {$from} para {$to}, por " . config('mail.default') . '…');

        try {
            Mail::to($to)->sendNow($mail);
        } catch (\Throwable $e) {
            $this->error('Não foi possível enviar: ' . $e->getMessage());

            return self::FAILURE;
        }

        $this->info(config('mail.default') === 'log'
            ? 'Escrito em storage/logs/laravel.log (MAIL_MAILER=log: nada sai do servidor).'
            : 'Enviado. Veja a caixa de entrada — e o spam, da primeira vez.');

        return self::SUCCESS;
    }
}
