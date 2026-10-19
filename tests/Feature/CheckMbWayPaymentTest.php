<?php

use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Support\Facades\Http;

function pagamentoPendente(?string $requestId = 'REQ123'): Payment
{
    $order = Order::create([
        'total' => '0.01', 'buyer_name' => 'T',
        'buyer_email' => 't@t.pt', 'buyer_phone' => '935566333',
    ]);

    return $order->payments()->create([
        'reference'           => 'T' . fake()->unique()->numberBetween(1, 99999),
        'method'              => 'mbway',
        'amount'              => '0.01',
        'status'              => Payment::STATUS_REQUESTED,
        'provider_request_id' => $requestId,
    ]);
}

function verificador(): CheckMbWayPayment
{
    return new CheckMbWayPayment(new MbWayClient('UWP-TESTE'));
}

it('marca como pago quando o estado é 000', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $payment = verificador()->check(pagamentoPendente());

    expect($payment->status)->toBe(Payment::STATUS_PAID)
        ->and($payment->provider_status)->toBe('000');
});

it('marca como recusado em 020 e em 122', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '020', 'Message' => 'Declined'])]);
    expect(verificador()->check(pagamentoPendente())->status)->toBe(Payment::STATUS_REJECTED);

    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '122', 'Message' => 'Declined'])]);
    expect(verificador()->check(pagamentoPendente())->status)->toBe(Payment::STATUS_REJECTED);
});

it('marca como expirado em 101', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '101', 'Message' => 'Expired'])]);

    expect(verificador()->check(pagamentoPendente())->status)->toBe(Payment::STATUS_EXPIRED);
});

it('deixa onde está um código que não conhece', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '777', 'Message' => '?'])]);

    expect(verificador()->check(pagamentoPendente())->status)->toBe(Payment::STATUS_REQUESTED);
});

it('não consulta um pagamento já resolvido', function () {
    Http::fake();

    $payment = pagamentoPendente();
    $payment->markAsPaid();

    verificador()->check($payment);

    Http::assertNothingSent();
});

it('não consulta quando não há RequestId', function () {
    Http::fake();

    $payment = pagamentoPendente(requestId: null);
    $payment->markAsUnknown();

    expect(verificador()->check($payment)->status)->toBe(Payment::STATUS_UNKNOWN);
    Http::assertNothingSent();
});
