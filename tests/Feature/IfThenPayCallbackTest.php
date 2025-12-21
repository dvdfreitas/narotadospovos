<?php

use App\Models\Payment;
use App\Services\Payments\IfThenPay\IfThenPayService;
use Illuminate\Support\Facades\Config;

// Configuração Global: Definimos uma chave fixa para todos os testes deste ficheiro
const TEST_KEY = 'CHAVE-SUPER-SECRETA';
beforeEach(function () {
    Config::set('services.ifthenpay.antiphishing_key', TEST_KEY);
});

it('marks payment as paid on valid callback', function () {
    $payment = Payment::create([
        'order_id' => 'ORDER123',
        'method'   => Payment::METHOD_MBWAY,
        'amount'   => 50.00,
        'status'   => Payment::STATUS_PENDING,
        'provider_request_id' => 'ID_MBWAY_123'
    ]);

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'ORDER123',
        'idpedido'   => 'ID_MBWAY_123',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 50.00,
    ]);

    $response->assertStatus(200);

    $payment->refresh();
    expect($payment->status)->toBe(Payment::STATUS_PAID);
});

it('ignores duplicate callback for paid payment', function () {
    $payment = Payment::create([
        'order_id' => 'ORDER123',
        'method'   => Payment::METHOD_MBWAY,
        'amount'   => 50.00,
        'status'   => Payment::STATUS_PAID,
    ]);

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'ORDER123',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 50.00,
    ]);

    $response->assertStatus(200);

    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID);

});


it('rejects callback with wrong payment method', function () {
    $payment = Payment::create([
        'order_id' => 'ORDER123',
        'method'   => 'multibanco',
        'amount'   => 50.00,
        'status'   => Payment::STATUS_PENDING,
    ]);

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'ORDER123',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 50.00,
    ]);

    $response->assertStatus(400);
});

it('returns 404 for unknown payment', function () {
    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'UNKNOWN',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 50.00,
    ]);

    $response->assertStatus(404);
});

it('rejects the callback if the antiphishing key is invalid', function () {

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => 'CHAVE-ERRADA',
        'referencia' => 'ORDER123',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 50.00,
    ]);

    $response->assertStatus(403);
});

it('fails if the callback amount does not match the database amount', function () {
    $payment = Payment::create([
        'order_id' => 'ORDER123',
        'method'   => Payment::METHOD_MBWAY,
        'amount'   => 50.00,
        'status'   => Payment::STATUS_PENDING,
    ]);

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'ORDER123',
        'estado'     => IfThenPayService::CODE_SUCCESS,
        'valor'      => 0.01,
    ]);

    $response->assertStatus(400);

    expect($payment->fresh()->status)->toBe(Payment::STATUS_PENDING);
});

it('marks payment as rejected when callback reports error', function () {

    $payment = Payment::create([
        'order_id' => 'ORDER123',
        'method'   => Payment::METHOD_MBWAY,
        'amount'   => 50.00,
        'status'   => Payment::STATUS_PENDING,
    ]);

    $response = $this->post('/api/ifthenpay/callback', [
        'chave'      => TEST_KEY,
        'referencia' => 'ORDER123',
        'estado'     => '999',
        'valor'      => 50.00,
    ]);

    $response->assertStatus(200);

    expect($payment->fresh()->status)->toBe(Payment::STATUS_REJECTED);
});
