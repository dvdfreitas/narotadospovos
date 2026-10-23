<?php

use App\Models\Order;
use App\Models\User;

beforeEach(function () {
    config(['app.admin_emails' => ['admin@exemplo.pt']]);
});

it('manda quem não tem sessão para o login', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('mostra o bazar e os últimos contributos a administradores', function () {
    Order::create([
        'total' => '25.00', 'status' => Order::STATUS_PAID, 'paid_at' => now(),
        'buyer_name' => 'Maria Silva', 'buyer_email' => 'maria@exemplo.pt', 'buyer_phone' => '935566333',
    ]);

    $this->actingAs(User::factory()->create(['name' => 'Ana Admin', 'email' => 'admin@exemplo.pt']))
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Olá, Ana')
        ->assertSee('Total angariado')
        ->assertSee('25,00 €')
        ->assertSee('Maria Silva');
});

it('esconde os números do bazar a quem não é administrador', function () {
    Order::create([
        'total' => '25.00', 'status' => Order::STATUS_PAID, 'paid_at' => now(),
        'buyer_name' => 'Maria Silva', 'buyer_email' => 'maria@exemplo.pt', 'buyer_phone' => '935566333',
    ]);

    $this->actingAs(User::factory()->create(['email' => 'outro@exemplo.pt']))
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Conteúdo do site')
        ->assertDontSee('Total angariado')
        ->assertDontSee('Maria Silva');
});

it('no site público, quem tem sessão vê o primeiro nome com um atalho para o painel', function () {
    $this->actingAs(User::factory()->create(['name' => 'Ana Maria Costa']))
        ->get('/noticias')
        ->assertSee('Ana')
        ->assertDontSee('Ana Maria Costa')
        ->assertSee('href="' . route('dashboard') . '"', false);
});

it('no site público, quem não tem sessão não vê o atalho', function () {
    $this->get('/noticias')
        ->assertDontSee('href="' . route('dashboard') . '"', false);
});
