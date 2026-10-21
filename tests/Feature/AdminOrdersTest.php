<?php

use App\Models\Order;
use App\Models\User;
use Livewire\Volt\Volt;

beforeEach(function () {
    config(['app.admin_emails' => ['admin@exemplo.pt']]);
});

function pedido(array $attributes = []): Order
{
    return Order::create([
        'total'       => '25.00',
        'buyer_name'  => 'Maria Silva',
        'buyer_email' => 'maria@exemplo.pt',
        'buyer_phone' => '935566333',
        'tax_number'  => '123456789',
        ...$attributes,
    ]);
}

it('manda quem não tem sessão para o login', function () {
    $this->get('/admin/pagamentos')->assertRedirect('/login');
});

it('recusa contas que não são de administrador', function () {
    $this->actingAs(User::factory()->create(['email' => 'outro@exemplo.pt']))
        ->get('/admin/pagamentos')
        ->assertForbidden();
});

it('recusa o email de administrador por verificar', function () {
    $this->actingAs(User::factory()->unverified()->create(['email' => 'admin@exemplo.pt']))
        ->get('/admin/pagamentos')
        ->assertForbidden();
});

it('mostra os dados do formulário ao administrador', function () {
    pedido();

    $this->actingAs(User::factory()->create(['email' => 'Admin@Exemplo.pt']))
        ->get('/admin/pagamentos')
        ->assertOk()
        ->assertSee('Maria Silva')
        ->assertSee('maria@exemplo.pt')
        ->assertSee('935566333');
});

it('filtra por estado sem a pesquisa escapar ao filtro', function () {
    pedido(['buyer_name' => 'Ana Paga', 'status' => Order::STATUS_PAID]);
    pedido(['buyer_name' => 'Ana Pendente']);

    $this->actingAs(User::factory()->create(['email' => 'admin@exemplo.pt']));

    Volt::test('admin.orders-index')
        ->set('status', Order::STATUS_PAID)
        ->set('search', 'Ana')
        ->assertSee('Ana Paga')
        ->assertDontSee('Ana Pendente');
});

it('mostra o detalhe com NIF', function () {
    $order = pedido();

    $this->actingAs(User::factory()->create(['email' => 'admin@exemplo.pt']));

    Volt::test('admin.orders-index')
        ->call('show', $order->id)
        ->assertSee('Encomenda #' . $order->id)
        ->assertSee('123456789');
});

it('exporta CSV', function () {
    pedido();

    $this->actingAs(User::factory()->create(['email' => 'admin@exemplo.pt']));

    Volt::test('admin.orders-index')
        ->call('export')
        ->assertFileDownloaded('loja-solidaria-' . now()->format('Y-m-d') . '.csv');
});
