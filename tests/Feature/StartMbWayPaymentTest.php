<?php

use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\Payments\StartMbWayPayment;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

const API = 'api.ifthenpay.com/*';

function servico(): StartMbWayPayment
{
    return new StartMbWayPayment(new MbWayClient('UWP-TESTE'));
}

function encomenda(): Order
{
    return Order::create([
        'total'       => '0.01',
        'buyer_name'  => 'Teste',
        'buyer_email' => 'teste@exemplo.pt',
        'buyer_phone' => '935566333',
    ]);
}

function pedidoAceite(): array
{
    return [
        'Status'    => '000',
        'Message'   => 'Success',
        'RequestId' => 'nqZze2cjTmkKx6HlWByb',
    ];
}

it('liga o pagamento ao que está a pagar', function () {
    Http::fake([API => Http::response(pedidoAceite())]);

    $order = encomenda();
    $payment = servico()->start($order, '0.01', '935566333', 'Teste');

    expect($payment->payable_type)->toBe(Order::class)
        ->and($payment->payable_id)->toBe($order->id)
        ->and($payment->payable->is($order))->toBeTrue();
});

it('atribui uma referência com o prefixo do ambiente', function () {
    Http::fake([API => Http::response(pedidoAceite())]);

    $payment = servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    // Em testes o APP_ENV é "testing", logo o prefixo é T.
    expect($payment->reference)->toBe('T' . $payment->id)
        ->and(strlen($payment->reference))->toBeLessThanOrEqual(15);
});

it('envia a nossa referência como orderId', function () {
    Http::fake([API => Http::response(pedidoAceite())]);

    $payment = servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    Http::assertSent(fn ($request) => $request['orderId'] === $payment->reference);
});

it('fica à espera quando a ifthenpay aceita', function () {
    Http::fake([API => Http::response(pedidoAceite())]);

    $payment = servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    expect($payment->status)->toBe(Payment::STATUS_REQUESTED)
        ->and($payment->provider_request_id)->toBe('nqZze2cjTmkKx6HlWByb')
        ->and($payment->expires_at->diffInMinutes(now()))->toBeLessThanOrEqual(4);
});

it('falha quando a ifthenpay recusa criar o pedido', function () {
    Http::fake([API => Http::response(['Status' => '999', 'Message' => 'Error'])]);

    $payment = servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    expect($payment->status)->toBe(Payment::STATUS_FAILED)
        ->and($payment->provider_request_id)->toBeNull();
});

it('fica em desconhecido quando não conseguimos falar com a ifthenpay', function () {
    Http::fake(fn () => throw new ConnectionException('timeout'));

    $payment = servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    // A linha tem de existir e ter referência: é por ela que a
    // reconciliação vai procurar o pagamento no histórico da ifthenpay.
    expect($payment->status)->toBe(Payment::STATUS_UNKNOWN)
        ->and($payment->reference)->not->toBeNull()
        ->and(Payment::where('reference', $payment->reference)->exists())->toBeTrue();
});

it('nunca deixa um pagamento sem referência', function () {
    Http::fake([API => Http::response(pedidoAceite())]);

    servico()->start(encomenda(), '0.01', '935566333', 'Teste');
    servico()->start(encomenda(), '0.01', '935566333', 'Teste');

    expect(Payment::whereNull('reference')->count())->toBe(0)
        ->and(Payment::distinct('reference')->count('reference'))->toBe(2);
});
