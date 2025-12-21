{{--
    FILE: resources/views/livewire/campaigns/christmas25/donation-modal.blade.php
--}}

<?php

use App\Models\Donation;
use App\Services\Payments\IfThenPay\IfThenPayService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use function Livewire\Volt\{state, rules, on};
use App\Enums\DonationStatus;


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
// ACTIONS
// -----------------------------------------------------------------------------

on([
    'open-donation-modal' => function ($type = 'papas', $amount = 5) {
        $this->resetValidation();
        $this->reset(['donor_name', 'donor_email', 'donor_phone', 'nif', 'public_message', 'gift_recipient_name', 'gift_message', 'createdDonation', 'terms']);

        $this->is_anonymous = false;
        $this->is_gift = false;
        $this->selectedProduct = $type;
        $this->amount = $amount;
        $this->step = 1;

        // --- LAZY TESTING MODE (Apenas em local) ---
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

    // 1. CRIAR O DONATIVO (Pending)
    $donation = Donation::create([
        'campaign_slug' => 'natal-25',
        'amount' => $this->amount,
        'status' => 'pending',

        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'donor_phone' => $this->donor_phone,
        'nif' => $this->nif ?: null,

        'is_anonymous' => (bool) $this->is_anonymous,
        'access_code' => Str::random(12),
        'terms_accepted_at' => now(),

        'campaign_data' => [
            'item_type' => $this->selectedProduct,
            'public_message' => $this->public_message,
            'is_gift' => (bool) $this->is_gift,
            'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
            'gift_message' => $this->is_gift ? $this->gift_message : null,
        ],
    ]);

    try {
        // 2. PEDIR AO GATEWAY
        $result = $paymentService->requestMbWayPayment($this->donor_phone, $this->amount, (string) $donation->id, 'Donativo #' . $donation->id);


try {
    $result = $paymentService->requestMbWayPayment(
        $this->donor_phone,
        $this->amount,
        (string) $donation->id,
        'Donativo #' . $donation->id
    );

    if ($result->isSuccess()) {
        // Não forçar 'paid'. Mantém como pending até integrares callback.
        // Se quiseres simular confirmação temporariamente:
        // $donation->update(['status' => DonationStatus::Confirmed]);

        $this->createdDonation = $donation;
        $this->step = 2;
        $this->dispatch('donation-added');
    } else {
        $this->addError('donor_phone', 'Erro MB WAY: ' . $result->message);
    }
} catch (\RuntimeException $e) {
    $this->addError('donor_phone', 'Erro na resposta do fornecedor: ' . $e->getMessage());
} catch (\Exception $e) {
    $this->addError('donor_phone', 'Erro técnico: ' . $e->getMessage());
}

    } catch (\RuntimeException $e) {
        $this->addError('donor_phone', 'Erro na resposta do fornecedor: ' . $e->getMessage());
    } catch (\Exception $e) {
        $this->addError('donor_phone', 'Erro técnico: ' . $e->getMessage());
    }
};

?>

<div>
    {{-- MODAL WRAPPER --}}
    <div x-data="{ show: @entangle('showModal').live }" x-show="show" x-on:keydown.escape.window="show = false"
        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        {{-- Backdrop --}}
        <div x-show="show" class="fixed inset-0 bg-emerald-950/40 backdrop-blur-sm transition-opacity"
            @click="show = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show"
                class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-emerald-100">

                {{-- STEP 1: FORMULÁRIO --}}
                @if ($step === 1)
                    <div
                        class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-emerald-800 flex items-center gap-2">
                            <span>🎁</span> Escolhe o teu Impacto
                        </h3>
                        <button wire:click="$set('showModal', false)" class="text-neutral-400 hover:text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="px-6 py-6 space-y-6">

                            {{-- Products --}}
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-neutral-500 mb-3">O
                                    que queres oferecer?</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    {{-- 5€ Papas --}}
                                    <button type="button" wire:click="selectProduct('papas', 5)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'papas' ? 'border-orange-400 bg-orange-50 ring-1 ring-orange-400' : 'border-neutral-200 bg-white hover:border-orange-200' }}">
                                        <div
                                            class="h-12 w-12 flex-shrink-0 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl mr-3">
                                            🥣</div>
                                        <div>
                                            <p class="font-bold text-neutral-800">Papas</p>
                                            <p class="text-xs text-neutral-500">Refeições quentes.</p>
                                        </div>
                                        <div class="ml-auto font-bold text-orange-700 text-lg">5€</div>
                                    </button>

                                    {{-- 12€ Milk --}}
                                    <button type="button" wire:click="selectProduct('leite', 12)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'leite' ? 'border-blue-400 bg-blue-50 ring-1 ring-blue-400' : 'border-neutral-200 bg-white hover:border-blue-200' }}">
                                        <div
                                            class="h-12 w-12 flex-shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl mr-3">
                                            🍼</div>
                                        <div>
                                            <p class="font-bold text-neutral-800">Leite Bebé</p>
                                            <p class="text-xs text-neutral-500">Lata essencial.</p>
                                        </div>
                                        <div class="ml-auto font-bold text-blue-700 text-lg">12€</div>
                                    </button>

                                    {{-- 25€ Basket --}}
                                    <button type="button" wire:click="selectProduct('crianca', 25)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'crianca' ? 'border-purple-400 bg-purple-50 ring-1 ring-purple-400' : 'border-neutral-200 bg-white hover:border-purple-200' }}">
                                        <div
                                            class="h-12 w-12 flex-shrink-0 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl mr-3">
                                            🧸</div>
                                        <div>
                                            <p class="font-bold text-neutral-800">Cabaz Criança</p>
                                            <p class="text-xs text-neutral-500">Higiene e bens.</p>
                                        </div>
                                        <div class="ml-auto font-bold text-purple-700 text-lg">25€</div>
                                    </button>

                                    {{-- 50€ Family --}}
                                    <button type="button" wire:click="selectProduct('familia', 50)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'familia' ? 'border-red-400 bg-red-50 ring-1 ring-red-400' : 'border-neutral-200 bg-white hover:border-red-200' }}">
                                        <div
                                            class="h-12 w-12 flex-shrink-0 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xl mr-3">
                                            ❤️</div>
                                        <div>
                                            <p class="font-bold text-neutral-800">Cabaz Família</p>
                                            <p class="text-xs text-neutral-500">Apoio mensal.</p>
                                        </div>
                                        <div class="ml-auto font-bold text-red-700 text-lg">50€</div>
                                    </button>
                                </div>

                                {{-- Custom Amount --}}
                                <div class="mt-3 relative" @click="$wire.set('selectedProduct', 'custom')">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 font-bold">€</span>
                                    <input type="number" wire:model="amount" step="0.01" min="1"
                                        class="w-full pl-8 pr-4 py-3 rounded-xl border-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-bold
                                        {{ $selectedProduct === 'custom' ? 'border-emerald-500 bg-emerald-50/30' : 'border-neutral-200' }}">
                                </div>
                                @error('amount')
                                    <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Details --}}
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide">Os
                                        teus dados</label>

                                    <input type="text" wire:model="donor_name" placeholder="O teu Nome"
                                        class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_name')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror

                                    <input type="email" wire:model="donor_email" placeholder="Email (para o recibo)"
                                        class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_email')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror

                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="tel" wire:model="donor_phone" placeholder="Telemóvel (MB)"
                                                class="w-full text-sm rounded-lg border-neutral-300">
                                            @error('donor_phone')
                                                <span class="text-xs text-red-500">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="nif" placeholder="NIF (Opcional)"
                                                maxlength="9" class="w-full text-sm rounded-lg border-neutral-300">
                                        </div>
                                    </div>
                                    @error('nif')
                                        <span class="text-xs text-red-500">{{ $message }}</span>
                                    @enderror

                                    <label class="flex items-center gap-2 cursor-pointer pt-1">
                                        <input type="checkbox" wire:model="is_anonymous"
                                            class="rounded text-emerald-600 border-neutral-300">
                                        <span class="text-xs text-neutral-600">Doar como Anónimo</span>
                                    </label>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-neutral-700 uppercase tracking-wide mb-1">Mensagem
                                            Pública</label>
                                        <textarea wire:model="public_message" rows="2" placeholder="Deixa uma mensagem na árvore..."
                                            class="w-full text-sm rounded-lg border-neutral-300"></textarea>
                                    </div>

                                    <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-bold text-neutral-700">É um Presente? 🎁</span>
                                            <button type="button" wire:click="$toggle('is_gift')"
                                                class="{{ $is_gift ? 'bg-emerald-600' : 'bg-neutral-300' }} relative inline-flex h-5 w-9 rounded-full transition-colors">
                                                <span
                                                    class="{{ $is_gift ? 'translate-x-4' : 'translate-x-1' }} inline-block h-3 w-3 transform rounded-full bg-white transition-transform mt-1"></span>
                                            </button>
                                        </div>
                                        @if ($is_gift)
                                            <div class="space-y-2 animate-in fade-in">
                                                <input type="text" wire:model="gift_recipient_name"
                                                    placeholder="Nome do Destinatário"
                                                    class="w-full text-xs rounded border-neutral-300">
                                                @error('gift_recipient_name')
                                                    <span class="text-xs text-red-500 block">{{ $message }}</span>
                                                @enderror

                                                {{-- SEM EMAIL DE DESTINATÁRIO --}}

                                                <textarea wire:model="gift_message" rows="2" placeholder="Mensagem para o postal..."
                                                    class="w-full text-xs rounded border-neutral-300"></textarea>

                                                <p
                                                    class="text-[10px] text-emerald-700 italic bg-emerald-50 p-1.5 rounded">
                                                    ℹ️ Receberás um link do postal para enviares à pessoa.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- CHECKBOX RGPD --}}
                            <div class="pt-2 border-t border-gray-100">
                                <label class="flex items-start gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="terms"
                                        class="mt-1 rounded text-emerald-600 border-neutral-300 focus:ring-emerald-500">
                                    <div class="text-xs text-neutral-500">
                                        Aceito a
                                        <a href="{{ route('christmas.privacy') }}" target="_blank"
                                            class="font-bold text-emerald-700 hover:underline">
                                            Política de Privacidade
                                        </a>.
                                        @if ($is_gift)
                                            <span class="block mt-0.5 text-neutral-400">
                                                Garanto que uso o nome do destinatário apenas para gerar o postal.
                                            </span>
                                        @endif
                                    </div>
                                </label>
                                @error('terms')
                                    <span
                                        class="text-xs text-red-500 font-bold block mt-1 ml-6">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="w-full rounded-xl bg-emerald-600 py-4 text-base font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500 hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2">
                                <span>Pagar {{ $amount }}€ com MB WAY</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </button>
                            <p class="text-[10px] text-center text-neutral-400 mt-2">Pagamento seguro processado pela
                                Ifthenpay</p>
                        </div>
                    </form>
                @endif

                {{-- STEP 2: SUCESSO (Mensagem de Envio do Pedido) --}}
                {{-- STEP 2: SUCESSO --}}
                @if ($step === 2 && $createdDonation)
                    <div class="p-8 text-center space-y-6 animate-in fade-in duration-500">
                        <div
                            class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4 animate-bounce">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-emerald-900">Obrigado!</h3>
                            <p class="text-sm text-neutral-500 mt-2 max-w-xs mx-auto">
                                O teu apoio já chegou à Casa da Mamé.<br>
                                <strong class="text-emerald-600">A tua prenda já está na árvore!</strong>
                            </p>
                        </div>

                        <div class="mt-4 flex flex-col gap-3">
                            {{-- Botão para o Postal do Doador (Antigo Recibo) --}}
                            <a href="{{ route('cards.christmas', ['code' => $createdDonation->access_code, 'view' => 'donor']) }}"
                                target="_blank"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow transition-colors flex items-center justify-center gap-2">
                                {{-- Ícone de Envelope/Postal --}}
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span>Ver o meu Postal</span>
                            </a>

                            {{-- Botão para o Postal da Oferta (Só aparece se for Prenda) --}}
                            @if ($createdDonation->is_gift)
                                <a href="{{ route('cards.christmas', ['code' => $createdDonation->access_code]) }}"
                                    target="_blank"
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                                        </path>
                                    </svg>
                                    Postal para Oferecer
                                </a>
                                <p class="text-xs text-neutral-400">
                                    Copia o link deste postal e envia à pessoa.
                                </p>
                            @endif
                        </div>

                        <button wire:click="$set('showModal', false)"
                            class="text-sm text-neutral-400 underline hover:text-neutral-600 pt-2">
                            Fechar janela
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
