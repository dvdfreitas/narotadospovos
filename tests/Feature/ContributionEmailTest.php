<?php

use App\Mail\ContributionConfirmed;
use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

function contributo(): Payment
{
    $order = Order::create([
        'total' => '25.00', 'buyer_name' => 'David Freitas',
        'buyer_email' => 'david@exemplo.pt', 'buyer_phone' => '935566333',
    ]);

    $order->items()->create([
        'product_name' => 'Cabaz solidário', 'variant_label' => '1 cabaz',
        'unit_price' => '25.00', 'quantity' => 1,
    ]);

    return $order->payments()->create([
        'reference' => 'T' . fake()->unique()->numberBetween(1, 99999),
        'method' => 'mbway', 'amount' => '25.00',
        'status' => Payment::STATUS_REQUESTED,
        'provider_request_id' => 'REQ-MAIL',
    ]);
}

it('agradece por email quando o contributo é pago', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $payment = (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    expect($payment->status)->toBe(Payment::STATUS_PAID);

    Mail::assertQueued(ContributionConfirmed::class, fn ($mail) =>
        $mail->hasTo('david@exemplo.pt')
        && $mail->order->access_code === $payment->payable->access_code);
});

it('não agradece quando o pagamento não se concretiza', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '020', 'Message' => 'Declined'])]);

    (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    Mail::assertNothingQueued();
});

it('mantém o pagamento pago mesmo que o email rebente', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    // Um remetente inválido faz o envio rebentar.
    config(['mail.from.address' => '']);
    Mail::shouldReceive('to')->andThrow(new RuntimeException('servidor de email em baixo'));

    $payment = (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    // O dinheiro entrou. Um email que não sai não desfaz isso.
    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID);
});

it('agradece uma só vez quando dois caminhos confirmam ao mesmo tempo', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    // O ecrã de espera e a notificação carregam o pagamento no mesmo
    // instante: ambos o veem requested, antes de qualquer um confirmar.
    $payment         = contributo();
    $pelaNotificacao = Payment::find($payment->id);
    $peloEcra        = Payment::find($payment->id);

    $check = new CheckMbWayPayment(new MbWayClient('UWP-TESTE'));

    $check->check($pelaNotificacao);
    $primeiraHora = $pelaNotificacao->fresh()->confirmed_at;

    $this->travel(5)->seconds();
    $check->check($peloEcra);

    Mail::assertQueuedCount(1);

    // Quem chegou em segundo não reescreve a hora de quem chegou primeiro.
    expect($payment->fresh()->confirmed_at->equalTo($primeiraHora))->toBeTrue()
        ->and($peloEcra->status)->toBe(Payment::STATUS_PAID);
});
