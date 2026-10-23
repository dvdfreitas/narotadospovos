<?php

use App\Models\Order;
use App\Models\Product;

it('cria encomendas fictícias com linhas e pagamento', function () {
    $product = Product::create(['name' => 'Cabaz', 'slug' => 'cabaz-sim', 'unit' => 'un']);
    $product->variants()->create(['label' => '1 cabaz', 'quantity' => 1, 'price' => '25.00', 'is_active' => true]);

    $this->artisan('bazar:simular', ['quantidade' => 5])->assertSuccessful();

    expect(Order::count())->toBe(5)
        ->and(Order::doesntHave('items')->count())->toBe(0)
        ->and(Order::doesntHave('payments')->count())->toBe(0)
        ->and(Order::paid()->whereNull('paid_at')->count())->toBe(0);
});

it('recusa correr sem produtos', function () {
    $this->artisan('bazar:simular')->assertFailed();
});
