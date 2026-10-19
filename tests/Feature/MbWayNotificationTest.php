<?php

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

const STATUS_API = 'api.ifthenpay.com/spg/payment/mbway/status*';

/**
 * Um pagamento já enviado e à espera de decisão do cliente.
 */
function pagamentoAEspera(?string $requestId = 'REQ123'): Payment
{
    $order = Order::create([
        'total'       => '0.01',
        'buyer_name'  => 'Teste',
        'buyer_email' => 'teste@exemplo.pt',
        'buyer_phone' => '935566333',
    ]);

    $payment = $order->payments()->create([
        'reference'           => 'T' . fake()->unique()->numberBetween(1, 99999),
        'method'              => 'mbway',
        'amount'              => '0.01',
        'status'              => Payment::STATUS_REQUESTED,
        'provider_request_id' => $requestId,
    ]);

    return $payment;
}

/**
 * Assina como a ifthenpay assinaria: orderId + amount + requestId,
 * com a MB Way Key como segredo.
 */
function assinar(Payment $payment, string $requestId): string
{
    return hash_hmac(
        'sha256',
        $payment->reference . $payment->amount . $requestId,
        config('services.ifthenpay.mbway_key'),
    );
}

function notificar(Payment $payment, string $requestId, string $assinatura): \Illuminate\Testing\TestResponse
{
    return test()->postJson(
        "/api/mbway/notify/{$payment->reference}",
        [
            'RequestId' => $requestId,
            'Status'    => '000',
            'Message'   => 'Success',
            'CreatedAt' => '19-10-2026 16:00:00',
            'UpdateAt'  => '19-10-2026 16:00:12',
        ],
        ['X-Ifthenpay-Signature' => $assinatura],
    );
}

it('marca como pago depois de confirmar no endpoint de estado', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $payment = pagamentoAEspera();
    notificar($payment, 'REQ123', assinar($payment, 'REQ123'))->assertOk();

    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID)
        ->and($payment->fresh()->confirmed_at)->not->toBeNull();
});

it('decide pelo endpoint de estado e não pelo corpo da notificação', function () {
    // A notificação diz 000, mas o endpoint de estado diz 020.
    Http::fake([STATUS_API => Http::response(['Status' => '020', 'Message' => 'Declined'])]);

    $payment = pagamentoAEspera();
    notificar($payment, 'REQ123', assinar($payment, 'REQ123'))->assertOk();

    expect($payment->fresh()->status)->toBe(Payment::STATUS_REJECTED);
});

it('recusa uma assinatura inválida sem alterar nada', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000'])]);

    $payment = pagamentoAEspera();
    notificar($payment, 'REQ123', 'assinatura-forjada')->assertForbidden();

    expect($payment->fresh()->status)->toBe(Payment::STATUS_REQUESTED);
    Http::assertNothingSent();
});

it('devolve 404 para uma referência desconhecida', function () {
    test()->postJson('/api/mbway/notify/NAO-EXISTE', [])->assertNotFound();
});

it('não reprocessa um pagamento já resolvido', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000'])]);

    $payment = pagamentoAEspera();
    $payment->markAsPaid();
    $confirmadoEm = $payment->fresh()->confirmed_at;

    notificar($payment, 'REQ123', assinar($payment, 'REQ123'))->assertOk();

    // O confirmed_at não pode ser reescrito com uma hora posterior à real.
    expect($payment->fresh()->confirmed_at->eq($confirmadoEm))->toBeTrue();
    Http::assertNothingSent();
});

it('recupera o RequestId quando o pagamento ficou em desconhecido', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $payment = pagamentoAEspera(requestId: null);
    $payment->markAsUnknown();

    notificar($payment, 'REQ-NOVO', assinar($payment, 'REQ-NOVO'))->assertOk();

    expect($payment->fresh()->provider_request_id)->toBe('REQ-NOVO')
        ->and($payment->fresh()->status)->toBe(Payment::STATUS_PAID);
});

it('mantém o RequestId que já tinha em vez do que vem no corpo', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000'])]);

    $payment = pagamentoAEspera(requestId: 'REQ-NOSSO');
    notificar($payment, 'REQ-INTRUSO', assinar($payment, 'REQ-INTRUSO'))->assertOk();

    expect($payment->fresh()->provider_request_id)->toBe('REQ-NOSSO');
    Http::assertSent(fn ($request) => str_contains($request->url(), 'REQ-NOSSO'));
});

it('guarda o corpo cru da notificação', function () {
    Http::fake([STATUS_API => Http::response(['Status' => '000'])]);

    $payment = pagamentoAEspera();
    notificar($payment, 'REQ123', assinar($payment, 'REQ123'))->assertOk();

    expect($payment->fresh()->provider_payload)
        ->toHaveKey('UpdateAt', '19-10-2026 16:00:12');
});
