<?php

use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Volt\Volt;

function encomendaPublica(array $attributes = []): Order
{
    $order = Order::create([
        'total'        => '25.00',
        'status'       => Order::STATUS_PAID,
        'paid_at'      => now(),
        'buyer_name'   => 'Maria da Conceição Silva',
        'buyer_email'  => 'maria@exemplo.pt',
        'buyer_phone'  => '935566333',
        'is_anonymous' => false,
        ...$attributes,
    ]);

    $order->items()->create([
        'product_name' => 'Cabaz solidário', 'variant_label' => '1 cabaz',
        'unit_price' => '25.00', 'quantity' => 1,
    ]);

    return $order;
}

it('marca a encomenda como paga quando o pagamento entra', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $order = encomendaPublica(['status' => Order::STATUS_PENDING, 'paid_at' => null]);
    $payment = $order->payments()->create([
        'reference' => 'T1', 'method' => 'mbway', 'amount' => '25.00',
        'status' => Payment::STATUS_REQUESTED, 'provider_request_id' => 'REQ-1',
    ]);

    (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check($payment);

    $order->refresh();
    expect($order->status)->toBe(Order::STATUS_PAID)
        ->and($order->paid_at)->not->toBeNull();
});

it('deixa a encomenda pendente quando o pagamento é recusado', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '020', 'Message' => 'Declined'])]);

    $order = encomendaPublica(['status' => Order::STATUS_PENDING, 'paid_at' => null]);
    $payment = $order->payments()->create([
        'reference' => 'T2', 'method' => 'mbway', 'amount' => '25.00',
        'status' => Payment::STATUS_REQUESTED, 'provider_request_id' => 'REQ-2',
    ]);

    (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check($payment);

    expect($order->refresh()->status)->toBe(Order::STATUS_PENDING);
});

it('mostra só o primeiro e o último nome', function () {
    expect(encomendaPublica()->publicName())->toBe('Maria Silva')
        ->and(encomendaPublica(['buyer_name' => '  Maria  '])->publicName())->toBe('Maria')
        ->and(encomendaPublica(['is_anonymous' => true])->publicName())->toBe('Anónimo');
});

it('lista os contributos pagos com nome, artigos e valor', function () {
    encomendaPublica();

    Volt::test('shop.contributions')
        ->assertSee('Quem já contribuiu')
        ->assertSee('Maria Silva')
        ->assertSee('Cabaz solidário — 1 cabaz')
        ->assertSee('25,00 €')
        ->assertDontSee('Conceição');
});

it('não lista encomendas por pagar', function () {
    encomendaPublica(['status' => Order::STATUS_PENDING, 'paid_at' => null, 'buyer_name' => 'João Pendente']);

    Volt::test('shop.contributions')
        ->assertDontSee('João Pendente')
        ->assertSee('Ainda ninguém contribuiu');
});

it('anda entre páginas com as setas, sem sair dos limites', function () {
    // 7 encomendas: a mais antiga fica sozinha na segunda página.
    foreach (range(1, 7) as $n) {
        encomendaPublica(['buyer_name' => "Pessoa{$n} Teste", 'paid_at' => now()->subDays($n)]);
    }

    Volt::test('shop.contributions')
        ->assertSee('1–6 de 7')
        ->assertSee('Pessoa1 Teste')
        ->assertDontSee('Pessoa7 Teste')
        ->call('previous')
        ->assertSet('page', 1)
        ->call('next')
        ->assertSet('page', 2)
        ->assertSee('7–7 de 7')
        ->assertSee('Pessoa7 Teste')
        ->assertDontSee('Pessoa1 Teste')
        ->call('next')
        ->assertSet('page', 2);
});

it('não mostra setas quando cabe tudo numa página', function () {
    encomendaPublica();

    Volt::test('shop.contributions')
        ->assertDontSee('Páginas de contributos');
});

it('volta à primeira página quando entra um contributo novo', function () {
    foreach (range(1, 7) as $n) {
        encomendaPublica(['paid_at' => now()->subDays($n)]);
    }

    Volt::test('shop.contributions')
        ->call('next')
        ->dispatch('contribution-paid')
        ->assertSet('page', 1);
});

it('mostra os anónimos como Anónimo', function () {
    encomendaPublica(['is_anonymous' => true]);

    Volt::test('shop.contributions')
        ->assertSee('Anónimo')
        ->assertDontSee('Maria');
});

it('nunca envia o email nem o telemóvel ao browser', function () {
    encomendaPublica();

    // A página inteira, com o snapshot do Livewire incluído.
    $this->get('/bazar-solidario')
        ->assertOk()
        ->assertSee('Maria Silva')
        ->assertDontSee('maria@exemplo.pt')
        ->assertDontSee('935566333');
});
