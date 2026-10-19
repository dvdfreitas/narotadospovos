<?php

namespace App\Providers;

use App\Services\IfThenPay\MbWayClient;
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
         */
        $this->app->singleton(MbWayClient::class, fn () => new MbWayClient(
            config('services.ifthenpay.mbway_key')
                ?? throw new RuntimeException('IFTHENPAY_MBWAY_KEY não está definida.'),
        ));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
