<?php

namespace App\Providers;

use App\Models\User;
use App\Services\IfThenPay\FakeMbWayClient;
use App\Services\IfThenPay\MbWayClient;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use RuntimeException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /**
         * O único sítio do projecto que sabe de onde vem a chave MB Way.
         *
         * Qualquer classe que peça um MbWayClient por type-hint
         * recebe-o já configurado.
         *
         * singleton: o cliente não guarda estado além da chave.
         *
         * A falta da chave rebenta com mensagem explícita, e só quando
         * alguém pedir o cliente — assim é possível correr migrações
         * sem a chave definida.
         *
         * IFTHENPAY_ENV escolhe o cliente: production fala com a
         * ifthenpay a sério, fake entra o FakeMbWayClient, que não paga
         * nada. Um valor que não seja nenhum dos dois rebenta: um engano
         * a escrever "fake" não pode cair em cobranças reais.
         *
         * fake num servidor com APP_ENV=production também rebenta, em vez
         * de obedecer: uma loja que aceitasse encomendas sem cobrar seria
         * pior do que uma em baixo.
         */
        $this->app->singleton(MbWayClient::class, function () {
            $env = config('services.ifthenpay.env');

            return match ($env) {
                'fake' => $this->app->isProduction()
                    ? throw new RuntimeException('IFTHENPAY_ENV=fake não pode ser usado com APP_ENV=production.')
                    : new FakeMbWayClient(),

                'production' => new MbWayClient(
                    config('services.ifthenpay.mbway_key')
                        ?? throw new RuntimeException('IFTHENPAY_MBWAY_KEY não está definida.'),
                ),

                default => throw new RuntimeException("IFTHENPAY_ENV tem de ser production ou fake, não \"{$env}\"."),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Ver config/app.php, 'admin_emails'. O email verificado é exigido
        // aqui e não só na rota, para que o Gate valha onde quer que se use.
        Gate::define('admin', fn (User $user) => $user->hasVerifiedEmail()
            && in_array(strtolower($user->email), config('app.admin_emails'), true));
    }
}
