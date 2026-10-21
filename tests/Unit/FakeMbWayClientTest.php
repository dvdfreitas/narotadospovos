<?php

use App\Services\IfThenPay\FakeMbWayClient;
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

it('escolhe o desfecho pelo último dígito do telemóvel', function () {
    $client = new FakeMbWayClient();
    $past = time() - 60;

    expect($client->checkStatus("FAKE-8-{$past}")->isPaid())->toBeTrue()
        ->and($client->checkStatus("FAKE-1-{$past}")->isRejected())->toBeTrue()
        ->and($client->checkStatus("FAKE-2-{$past}")->isExpired())->toBeTrue()
        ->and($client->requestPayment('L1', '5.00', '912345673', 'Teste')->wasAccepted())->toBeFalse();
});

it('simula a ifthenpay em baixo', function () {
    (new FakeMbWayClient())->requestPayment('L1', '5.00', '912345674', 'Teste');
})->throws(MbWayUnavailableException::class);
