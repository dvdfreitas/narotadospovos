<?php

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Livewire\Volt\Volt;

function cabaz(string $price = '25.00', bool $active = true): ProductVariant
{
    $product = Product::create([
        'name' => 'Cabaz solidário',
        'slug' => 'cabaz-' . fake()->unique()->numberBetween(1, 99999),
        'unit' => 'un',
    ]);

    return $product->variants()->create([
        'label'     => '1 cabaz',
        'quantity'  => 1,
        'price'     => $price,
        'is_active' => $active,
    ]);
}

it('repreça a selecção a partir da base de dados', function () {
    $variant = cabaz('25.00');

    Volt::test('shop.index')
        ->call('startCheckout', [
            // O browser diz que custa 1 cêntimo. A base de dados discorda.
            ['variantId' => $variant->id, 'quantity' => 2, 'unitPrice' => '0.01'],
        ])
        ->assertSet('lines.0.unit_price', '25.00')
        ->assertSet('lines.0.quantity', 2)
        ->assertSet('lines.0.product_name', 'Cabaz solidário');
});

it('ignora variantes que não existem', function () {
    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => 999999, 'quantity' => 1]])
        ->assertSet('lines', []);
});

it('ignora variantes desactivadas', function () {
    $variant = cabaz('25.00', active: false);

    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 1]])
        ->assertSet('lines', []);
});

it('limita a quantidade entre 1 e 99', function () {
    $variant = cabaz();

    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 5000]])
        ->assertSet('lines.0.quantity', 99);

    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => -3]])
        ->assertSet('lines.0.quantity', 1);
});

it('cria a encomenda com as linhas e pede o pagamento', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response([
        'Status' => '000', 'Message' => 'Success', 'RequestId' => 'REQ-LOJA',
    ])]);

    $variant = cabaz('25.00');

    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 2]])
        ->set('buyer_name', 'David Freitas')
        ->set('buyer_email', 'david@exemplo.pt')
        ->set('buyer_phone', '935566333')
        ->set('tax_number', '')
        ->set('is_anonymous', true)
        ->set('terms', true)
        ->call('placeOrder')
        ->assertHasNoErrors()
        ->assertSet('step', 2);

    $order = Order::first();

    expect($order->total)->toBe('50.00')
        ->and($order->is_anonymous)->toBeTrue()
        ->and($order->tax_number)->toBeNull()
        ->and($order->terms_accepted_at)->not->toBeNull()
        ->and($order->items)->toHaveCount(1)
        ->and($order->items->first()->unit_price)->toBe('25.00')
        ->and($order->payments->first()->status)->toBe(Payment::STATUS_REQUESTED)
        ->and($order->payments->first()->amount)->toBe('50.00');

    // O valor pedido à ifthenpay tem de ser exactamente o mesmo texto.
    Http::assertSent(fn ($request) => $request['amount'] === '50.00');
});

it('exige telemóvel válido e aceitação dos termos', function () {
    $variant = cabaz();

    Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 1]])
        ->set('buyer_name', 'David')
        ->set('buyer_email', 'david@exemplo.pt')
        ->set('buyer_phone', '210000000')
        ->set('terms', false)
        ->call('placeOrder')
        ->assertHasErrors(['buyer_phone', 'terms'])
        ->assertSet('step', 1);

    expect(Order::count())->toBe(0);
});

it('mostra cada desfecho com a sua mensagem', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response([
        'Status' => '000', 'Message' => 'Success', 'RequestId' => 'REQ-FIM',
    ])]);

    $variant = cabaz('25.00');

    $component = Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 1]])
        ->set('buyer_name', 'David')
        ->set('buyer_email', 'david@exemplo.pt')
        ->set('buyer_phone', '935566333')
        ->set('terms', true)
        ->call('placeOrder')
        ->assertSet('step', 2)
        ->assertSee('Confirme no seu telemóvel')
        ->assertSee('935566333');

    $payment = Payment::first();

    // Pago
    $payment->markAsPaid();
    $component->call('checkPayment')
        ->assertSet('step', 3)
        ->assertSee('Obrigado pelo seu contributo')
        ->assertSee(Order::first()->access_code);
});

it('convida a repetir quando expira, mas nunca quando é desconhecido', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response([
        'Status' => '000', 'Message' => 'Success', 'RequestId' => 'REQ-EXP',
    ])]);

    $variant = cabaz('25.00');

    $abrir = fn () => Volt::test('shop.index')
        ->call('startCheckout', [['variantId' => $variant->id, 'quantity' => 1]])
        ->set('buyer_name', 'David')
        ->set('buyer_email', 'david@exemplo.pt')
        ->set('buyer_phone', '935566333')
        ->set('terms', true)
        ->call('placeOrder');

    $c = $abrir();
    Payment::first()->markAsExpired();
    $c->call('checkPayment')->assertSee('O pedido expirou')->assertSee('Tentar de novo');

    Payment::query()->delete();
    Order::query()->delete();

    // Em unknown a ligação caiu e nunca soubemos o RequestId. O placeOrder
    // salta directo ao resultado — não há telemóvel a tocar por que esperar.
    Http::fake(fn () => throw new \Illuminate\Http\Client\ConnectionException('timeout'));

    $abrir()
        ->assertSet('step', 3)
        ->assertSee('Estamos a confirmar')
        ->assertDontSee('Tentar de novo');

    expect(Payment::first()->status)->toBe(Payment::STATUS_UNKNOWN);
});
