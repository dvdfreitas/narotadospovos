<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Services\Payments\IfThenPay\IfThenPayService;
use App\Services\Payments\IfThenPay\MbWayPaymentResult; // Assumindo que tens este DTO ou similar
use Livewire\Volt\Volt;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Nome do componente para facilitar a leitura
const COMPONENT = 'campaigns.christmas25.donation-modal';

test('it renders successfully and starts closed', function () {
    Volt::test(COMPONENT)
        ->assertSet('showModal', false)
        ->assertSet('step', 1)
        ->assertSee('Papas'); // Verifica se vê os produtos
});

test('it opens and resets data on event', function () {
    Volt::test(COMPONENT)
        ->set('donor_name', 'Old Name')
        ->dispatch('open-donation-modal')
        ->assertSet('showModal', true)
        ->assertSet('donor_name', '') // Verifica se limpou
        ->assertSet('amount', 5); // Default
});

test('validation rules apply', function () {
    Volt::test(COMPONENT)
        ->set('showModal', true)
        ->set('amount', '')
        ->set('donor_name', '')
        ->set('donor_email', 'not-an-email')
        ->set('donor_phone', '123') // Formato inválido
        ->set('terms', false)
        ->call('save')
        ->assertHasErrors([
            'amount', 
            'donor_name', 
            'donor_email', 
            'donor_phone', 
            'terms'
        ]);
});

test('gift validation logic works', function () {
    Volt::test(COMPONENT)
        ->set('showModal', true)
        ->set('is_gift', true)
        ->set('gift_recipient_name', '') // Vazio, mas é gift
        ->call('save')
        ->assertHasErrors(['gift_recipient_name']);
});

test('it sanitizes nif and phone input', function () {
    Volt::test(COMPONENT)
        ->set('nif', '123 456 789')
        ->assertSet('nif', '123456789') // Remove espaços
        ->set('donor_phone', '91-234-5678')
        ->assertSet('donor_phone', '912345678');
});

test('selecting a product updates amount and type', function () {
    Volt::test(COMPONENT)
        ->call('selectProduct', 'familia', 50)
        ->assertSet('selectedProduct', 'familia')
        ->assertSet('amount', 50);
});

