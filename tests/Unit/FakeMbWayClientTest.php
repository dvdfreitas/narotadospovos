<?php

use App\Services\IfThenPay\FakeMbWayClient;
use App\Services\IfThenPay\MbWayClient;
use App\Services\IfThenPay\MbWayUnavailableException;
use Illuminate\Support\Facades\Http;

// Liga a aplicação, para o Http::fake. Sem base de dados.
uses(Tests\TestCase::class);

it('não envia nada para a ifthenpay', function () {
    Http::fake();

    (new FakeMbWayClient())->requestPayment('L1', '5.00', '912345678', 'Teste');

    Http::assertNothingSent();
});

it('aceita o pedido e responde Pending até o cliente "decidir"', function () {
    $result = (new FakeMbWayClient())->requestPayment('L1', '5.00', '912345678', 'Teste');

    expect($result->wasAccepted())->toBeTrue()
        ->and((new FakeMbWayClient())->checkStatus($result->requestId)->status)->toBe('123');
});

/** Pede o pagamento e devolve a resposta da consulta, já depois do atraso. */
function desfecho(string $phone)
{
    $client = new FakeMbWayClient();
    $requestId = $client->requestPayment('L1', '5.00', $phone, 'Teste')->requestId;

    // O RequestId leva a hora do pedido; recuá-la salta o atraso.
    return $client->checkStatus(preg_replace('/\d+$/', (string) (time() - 60), $requestId));
}

it('paga com qualquer telemóvel, incluindo os acabados em 1 a 4', function () {
    foreach (['912345678', '935566333', '961234561', '921234564'] as $phone) {
        expect(desfecho($phone)->isPaid())->toBeTrue();
    }
});

it('os números de teste escolhem o desfecho', function () {
    expect(desfecho('910000001')->isRejected())->toBeTrue()
        ->and(desfecho('930000002')->isExpired())->toBeTrue()
        ->and((new FakeMbWayClient())->requestPayment('L1', '5.00', '910000003', 'Teste')->wasAccepted())->toBeFalse();
});

it('simula a ifthenpay em baixo', function () {
    (new FakeMbWayClient())->requestPayment('L1', '5.00', '910000004', 'Teste');
})->throws(MbWayUnavailableException::class);

/** O cliente é um singleton: cada teste pede um novo depois de mudar a configuração. */
function clienteMbWay(): MbWayClient
{
    app()->forgetInstance(MbWayClient::class);

    return app(MbWayClient::class);
}

it('IFTHENPAY_ENV=fake dá o cliente falso', function () {
    config(['services.ifthenpay.env' => 'fake']);

    expect(clienteMbWay())->toBeInstanceOf(FakeMbWayClient::class);
});

it('IFTHENPAY_ENV=production dá o cliente real', function () {
    config(['services.ifthenpay.env' => 'production', 'services.ifthenpay.mbway_key' => 'UWP-TESTE']);

    expect(clienteMbWay())->not->toBeInstanceOf(FakeMbWayClient::class)
        ->toBeInstanceOf(MbWayClient::class);
});

it('um valor desconhecido rebenta, em vez de cair no cliente real', function () {
    config(['services.ifthenpay.env' => 'fak', 'services.ifthenpay.mbway_key' => 'UWP-TESTE']);

    clienteMbWay();
})->throws(RuntimeException::class, 'IFTHENPAY_ENV tem de ser production ou fake');

it('fake num servidor de produção rebenta', function () {
    config(['services.ifthenpay.env' => 'fake']);
    app()->detectEnvironment(fn () => 'production');

    clienteMbWay();
})->throws(RuntimeException::class, 'não pode ser usado com APP_ENV=production');
