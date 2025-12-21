{{--
    FILE: resources/views/livewire/campaigns/christmas25/donation-modal.blade.php
--}}

<?php

use App\Enums\DonationStatus;
use App\Models\Donation;
use App\Services\Payments\IfThenPay\IfThenPayService;
use function Livewire\Volt\{state, rules, on};

// -----------------------------------------------------------------------------
// STATE
// -----------------------------------------------------------------------------

state([
    'showModal' => false,
    'step' => 1,
    'createdDonation' => null,

    // Dados do Donativo
    'amount' => 5,
    'selectedProduct' => 'papas',

    // Dados do Doador
    'donor_name' => '',
    'donor_email' => '',
    'donor_phone' => '',
    'nif' => '',
    'is_anonymous' => false,

    // Dados da Campanha (JSON)
    'public_message' => '',
    'is_gift' => false,
    'gift_recipient_name' => '',
    'gift_message' => '',

    // RGPD
    'terms' => false,
]);

// -----------------------------------------------------------------------------
// RULES
// -----------------------------------------------------------------------------

rules([
    'amount' => 'required|numeric|min:1',
    'donor_name' => 'required|string|max:255',
    'donor_email' => 'required|email|max:255',
    'donor_phone' => ['required', 'regex:/^9[1236][0-9]{7}$/'],
    'nif' => 'nullable|digits:9',

    // Campos opcionais que vão para o JSON
    'public_message' => 'nullable|string|max:140',
    'gift_recipient_name' => 'required_if:is_gift,true|nullable|string|max:255',
    'gift_message' => 'nullable|string|max:500',

    // Obrigatório
    'terms' => 'accepted',
]);

// -----------------------------------------------------------------------------
// EVENTS
// -----------------------------------------------------------------------------

on([
    'open-donation-modal' => function ($type = 'papas', $amount = 5) {
        $this->resetValidation();
        $this->reset([
            'donor_name',
            'donor_email',
            'donor_phone',
            'nif',
            'public_message',
            'gift_recipient_name',
            'gift_message',
            'createdDonation',
            'terms',
        ]);

        $this->is_anonymous = false;
        $this->is_gift = false;

        $this->selectedProduct = $type;
        $this->amount = $amount;
        $this->step = 1;

        // --- MODO DE TESTES (apenas em local) ---
        if (app()->environment('local')) {
            $this->donor_name = 'Test Doador';
            $this->donor_email = 'teste@exemplo.com';
            $this->donor_phone = '910000000';
            $this->nif = '999999990';
            $this->public_message = 'Feliz Natal a todos!';
            $this->terms = true;
        }

        $this->showModal = true;
    },
]);

// -----------------------------------------------------------------------------
// ACTIONS
// -----------------------------------------------------------------------------

$selectProduct = function ($type, $value) {
    $this->selectedProduct = $type;
    $this->amount = $value;
};

$save = function (IfThenPayService $paymentService) {
    $this->validate(null, [
        'donor_phone.required' => 'O telemóvel é necessário para o MB WAY.',
        'donor_phone.regex' => 'Introduza um número válido (91, 92, 93 ou 96).',
        'terms.accepted' => 'É necessário aceitar a Política de Privacidade.',
        'gift_recipient_name.required_if' => 'Indica o nome de quem vai receber a oferta.',
    ]);

    // 1) CRIAR O DONATIVO (Pendente)
    $donation = Donation::create([
        'campaign_slug' => 'natal-25',
        'amount' => $this->amount,
        'currency' => 'EUR',
        'status' => DonationStatus::Pending,

        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'donor_phone' => $this->donor_phone,
        'nif' => $this->nif ?: null,

        'is_anonymous' => (bool) $this->is_anonymous,
        'terms_accepted_at' => now(),

        'campaign_data' => [
            'item_type' => $this->selectedProduct,
            'public_message' => $this->public_message ?: null,
            'is_gift' => (bool) $this->is_gift,
            'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
            'gift_message' => $this->is_gift ? $this->gift_message : null,
        ],
    ]);

    // 2) PEDIR PAGAMENTO AO GATEWAY (MB WAY)
    try {
        $result = $paymentService->requestMbWayPayment(
            $this->donor_phone,
            $this->amount,
            (string) $donation->id,
            'Donativo #' . $donation->id
        );

        if ($result->isSuccess()) {
            // Mantém como Pendente até existir callback/confirmação real.
            $this->createdDonation = $donation;
            $this->step = 2;

            $this->dispatch('donation-added');
        } else {
            $this->addError(
                'donor_phone',
                'Não foi possível iniciar o pagamento por MB WAY. Tenta novamente.'
            );
        }
    } catch (\RuntimeException $e) {
        $this->addError('donor_phone', 'Erro na resposta do fornecedor: ' . $e->getMessage());
    } catch (\Exception $e) {
        $this->addError('donor_phone', 'Erro técnico: ' . $e->getMessage());
    }
};

// -----------------------------------------------------------------------------
// VIEW DATA (não-reactivo; serve apenas para simplificar o HTML)
// -----------------------------------------------------------------------------

state(['products' => [
    [
        'type' => 'papas',
        'amount' => 5,
        'title' => 'Papas',
        'desc' => 'Refeições quentes.',
        'emoji' => '🥣',
        'selected' => 'border-orange-400 bg-orange-50 ring-1 ring-orange-400',
        'idle' => 'border-neutral-200 bg-white hover:border-orange-200',
        'icon' => 'bg-orange-100 text-orange-600',
        'price' => 'text-orange-700',
    ],
    [
        'type' => 'leite',
        'amount' => 12,
        'title' => 'Leite Bebé',
        'desc' => 'Lata essencial.',
        'emoji' => '🍼',
        'selected' => 'border-blue-400 bg-blue-50 ring-1 ring-blue-400',
        'idle' => 'border-neutral-200 bg-white hover:border-blue-200',
        'icon' => 'bg-blue-100 text-blue-600',
        'price' => 'text-blue-700',
    ],
    [
        'type' => 'crianca',
        'amount' => 25,
        'title' => 'Cabaz Criança',
        'desc' => 'Higiene e bens.',
        'emoji' => '🧸',
        'selected' => 'border-purple-400 bg-purple-50 ring-1 ring-purple-400',
        'idle' => 'border-neutral-200 bg-white hover:border-purple-200',
        'icon' => 'bg-purple-100 text-purple-600',
        'price' => 'text-purple-700',
    ],
    [
        'type' => 'familia',
        'amount' => 50,
        'title' => 'Cabaz Família',
        'desc' => 'Apoio mensal.',
        'emoji' => '❤️',
        'selected' => 'border-red-400 bg-red-50 ring-1 ring-red-400',
        'idle' => 'border-neutral-200 bg-white hover:border-red-200',
        'icon' => 'bg-red-100 text-red-600',
        'price' => 'text-red-700',
    ],
]])->locked();

?>

<div>
    {{-- MODAL WRAPPER --}}
    <div
        x-data="{ show: @entangle('showModal').live }"
        x-show="show"
        x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        {{-- Backdrop --}}
        <div
            x-show="show"
            class="fixed inset-0 bg-emerald-950/40 backdrop-blur-sm transition-opacity"
            @click="show = false"
        ></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div
                x-show="show"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-emerald-100"
            >
                @if ($step === 1)
                    @include('livewire.campaigns.christmas25.partials.donation-step-form', [
                        'products' => $products,
                    ])
                @endif

                @if ($step === 2 && $createdDonation)
                    @include('livewire.campaigns.christmas25.partials.donation-step-success')
                @endif
            </div>
        </div>
    </div>
</div>
