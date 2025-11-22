<?php

use App\Models\Donation;
use App\Services\IfthenpayService;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, on};

// =================================================================
// 1. ESTADO
// =================================================================
state([
    'showModal' => false,
    'step' => 1,
    'createdDonation' => null,

    'amount' => 5,
    'selectedProduct' => 'food',

    // Doador
    'donor_name' => '',
    'donor_email' => '',
    'donor_phone' => '',
    'nif' => '',

    // Opções
    'is_anonymous' => false,
    'public_message' => '',

    // Prenda
    'is_gift' => false,
    'gift_recipient_name' => '',
    'gift_recipient_email' => '',
    'gift_message' => '',
]);

// =================================================================
// 2. REGRAS DE VALIDAÇÃO
// =================================================================
rules([
    'amount' => 'required|numeric|min:1',
    'donor_name' => 'required|string|max:255',
    'donor_email' => 'required|email|max:255',
    'donor_phone' => ['required', 'regex:/^9[1236][0-9]{7}$/'],
    'nif' => 'nullable|digits:9',
    'public_message' => 'nullable|string|max:140',
    'gift_recipient_name' => 'required_if:is_gift,true|nullable|string|max:255',
    'gift_recipient_email' => 'required_if:is_gift,true|nullable|email|max:255',
    'gift_message' => 'nullable|string|max:500',
]);

// =================================================================
// 3. ABRIR MODAL (Ouvinte de Eventos)
// =================================================================
on(['open-donation-modal' => function ($type = 'food', $amount = 5) {
    $this->resetValidation();

    // Reset dos campos
    $this->donor_name = '';
    $this->donor_email = '';
    $this->donor_phone = '';
    $this->nif = '';

    $this->public_message = '';
    $this->is_anonymous = false;
    $this->is_gift = false;
    $this->gift_recipient_name = '';
    $this->gift_recipient_email = '';
    $this->gift_message = '';

    // Define o produto selecionado (ou default)
    $this->selectedProduct = $type;
    $this->amount = $amount;

    $this->step = 1;
    $this->createdDonation = null;
    $this->showModal = true;
}]);

// Helper para mudar produto dentro do modal
$selectProduct = function($type, $value) {
    $this->selectedProduct = $type;
    $this->amount = $value;
};

// =================================================================
// 4. GUARDAR E PAGAR
// =================================================================
$save = function (IfthenpayService $paymentService) {

    // Mensagens Personalizadas em Português
    $messages = [
        'amount.required' => 'Por favor, escolha um valor.',
        'amount.min' => 'O valor mínimo é de 1€.',
        'donor_name.required' => 'O nome é obrigatório.',
        'donor_email.required' => 'O email é obrigatório.',
        'donor_email.email' => 'Introduza um email válido.',
        'donor_phone.required' => 'O telemóvel é necessário para o MB WAY.',
        'donor_phone.regex' => 'Introduza um número válido (91, 92, 93 ou 96).',
        'nif.digits' => 'O NIF deve ter 9 dígitos.',
        'gift_recipient_name.required_if' => 'Indique o nome do destinatário da prenda.',
        'gift_recipient_email.required_if' => 'Indique o email do destinatário.',
    ];

    // Validação
    $this->validate(null, $messages);

    // Criar Donativo (Pendente)
    $donation = Donation::create([
        'amount' => $this->amount,
        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'donor_phone' => $this->donor_phone,
        'nif' => $this->nif ?: null,

        'is_anonymous' => $this->is_anonymous,
        'public_message' => $this->public_message,
        'is_gift' => $this->is_gift,
        'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
        'gift_recipient_email' => $this->is_gift ? $this->gift_recipient_email : null,
        'gift_message' => $this->is_gift ? $this->gift_message : null,
        'payment_status' => 'pending',
        'access_code' => Str::random(12),
    ]);

    // Processar MB WAY
    try {
        $result = $paymentService->requestMbWayPayment(
            $this->donor_phone,
            $this->amount,
            $donation->id
        );

        if (isset($result['Estado']) && $result['Estado'] === '000') {
            // SUCESSO (Na simulação, marcamos logo como pago)
            $donation->update([
                'payment_status' => 'paid',
                'payment_gateway_id' => $result['IdPedido']
            ]);

            $this->createdDonation = $donation;
            $this->step = 2; // Avança para o sucesso
            $this->dispatch('donation-added'); // Atualiza a lista
        } else {
            $msgErro = $result['MsgDescricao'] ?? 'Erro desconhecido';
            if(str_contains($msgErro, 'Alias')) $msgErro = 'Número de telemóvel inválido ou sem MB WAY.';

            $this->addError('donor_phone', 'MB WAY: ' . $msgErro);
        }
    } catch (\Exception $e) {
        $this->addError('donor_phone', 'Erro técnico ao comunicar com o pagamento.');
    }
};

?>

<div>
    {{-- MODAL CONTAINER --}}
    <div x-data="{ show: @entangle('showModal').live }"
         x-show="show"
         x-on:keydown.escape.window="show = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        {{-- Backdrop --}}
        <div x-show="show" class="fixed inset-0 bg-emerald-900/40 backdrop-blur-sm transition-opacity" @click="show = false"></div>

        {{-- Painel --}}
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-emerald-100">

                {{-- ================================================== --}}
                {{-- PASSO 1: O FORMULÁRIO --}}
                {{-- ================================================== --}}
                @if($step === 1)
                    <div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-emerald-800 flex items-center gap-2">
                            <span>🎁</span> Escolha o seu Impacto
                        </h3>
                        <button wire:click="$set('showModal', false)" class="text-neutral-400 hover:text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="px-6 py-6 space-y-6">

                            {{-- GRID DE PRODUTOS --}}
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-widest text-neutral-500 mb-3">O que quer oferecer?</label>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    {{-- 5€ --}}
                                    <button type="button" wire:click="selectProduct('food', 5)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'food' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-neutral-200 bg-white hover:border-emerald-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl mr-3">🥣</div>
                                        <div><p class="font-bold text-neutral-800">Bens Alimentares</p><p class="text-xs text-neutral-500">Ajuda com papas.</p></div>
                                        <div class="ml-auto font-bold text-emerald-700 text-lg">5€</div>
                                    </button>

                                    {{-- 12€ --}}
                                    <button type="button" wire:click="selectProduct('milk', 12)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'milk' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-neutral-200 bg-white hover:border-emerald-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl mr-3">🍼</div>
                                        <div><p class="font-bold text-neutral-800">Leite Bebé</p><p class="text-xs text-neutral-500">Lata de leite.</p></div>
                                        <div class="ml-auto font-bold text-emerald-700 text-lg">12€</div>
                                    </button>

                                    {{-- 20€ --}}
                                    <button type="button" wire:click="selectProduct('hygiene', 20)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'hygiene' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-neutral-200 bg-white hover:border-emerald-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl mr-3">🧼</div>
                                        <div><p class="font-bold text-neutral-800">Kit Higiene</p><p class="text-xs text-neutral-500">Fraldas e limpeza.</p></div>
                                        <div class="ml-auto font-bold text-emerald-700 text-lg">20€</div>
                                    </button>

                                    {{-- 50€ --}}
                                    <button type="button" wire:click="selectProduct('family', 50)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'family' ? 'border-emerald-500 bg-emerald-50 ring-1 ring-emerald-500' : 'border-neutral-200 bg-white hover:border-emerald-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xl mr-3">❤️</div>
                                        <div><p class="font-bold text-neutral-800">Cabaz Família</p><p class="text-xs text-neutral-500">Apoio mensal.</p></div>
                                        <div class="ml-auto font-bold text-emerald-700 text-lg">50€</div>
                                    </button>
                                </div>

                                {{-- Valor Personalizado --}}
                                <div class="mt-3 relative" @click="$wire.set('selectedProduct', 'custom')">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 font-bold">€</span>
                                    <input type="number" wire:model="amount" step="0.01" min="1"
                                        class="w-full pl-8 pr-4 py-3 rounded-xl border-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-bold
                                        {{ $selectedProduct === 'custom' ? 'border-emerald-500 bg-emerald-50/30' : 'border-neutral-200' }}">
                                </div>
                                @error('amount') <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- FORMULÁRIO DE DADOS --}}
                            <div class="grid md:grid-cols-2 gap-6">

                                {{-- Coluna 1: Dados Pessoais --}}
                                <div class="space-y-3">
                                    <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide">Os teus dados</label>

                                    <input type="text" wire:model="donor_name" placeholder="O teu Nome" class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                    <input type="email" wire:model="donor_email" placeholder="Email" class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                    {{-- Telemóvel e NIF --}}
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="tel" wire:model="donor_phone" placeholder="Telemóvel (MB)" class="w-full text-sm rounded-lg border-neutral-300">
                                            @error('donor_phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="nif" placeholder="NIF (Opcional)" maxlength="9" class="w-full text-sm rounded-lg border-neutral-300">
                                            <p class="text-[10px] text-neutral-500 mt-1 leading-tight">
                                                Obrigatório para recibo fiscal.
                                            </p>
                                            @error('nif') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <label class="flex items-center gap-2 cursor-pointer pt-1">
                                        <input type="checkbox" wire:model="is_anonymous" class="rounded text-emerald-600 border-neutral-300">
                                        <span class="text-xs text-neutral-600">Doar como Anónimo</span>
                                    </label>
                                </div>

                                {{-- Coluna 2: Opções e Prenda --}}
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide mb-1">Mensagem Pública</label>
                                        <textarea wire:model="public_message" rows="2" placeholder="Deixa uma mensagem na árvore..." class="w-full text-sm rounded-lg border-neutral-300"></textarea>
                                    </div>

                                    {{-- Prenda --}}
                                    <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-xs font-bold text-neutral-700">É uma Prenda? 🎁</span>
                                            <button type="button" wire:click="$toggle('is_gift')" class="{{ $is_gift ? 'bg-emerald-600' : 'bg-neutral-300' }} relative inline-flex h-5 w-9 rounded-full transition-colors">
                                                <span class="{{ $is_gift ? 'translate-x-4' : 'translate-x-1' }} inline-block h-3 w-3 transform rounded-full bg-white transition-transform mt-1"></span>
                                            </button>
                                        </div>
                                        @if($is_gift)
                                            <div class="space-y-2 animate-in fade-in">
                                                <input type="text" wire:model="gift_recipient_name" placeholder="Nome do Destinatário" class="w-full text-xs rounded border-neutral-300">
                                                @error('gift_recipient_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                                <input type="email" wire:model="gift_recipient_email" placeholder="Email do Destinatário" class="w-full text-xs rounded border-neutral-300">
                                                @error('gift_recipient_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                                <textarea wire:model="gift_message" rows="2" placeholder="Mensagem privada..." class="w-full text-xs rounded border-neutral-300"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- BOTÃO --}}
                            <div class="pt-2">
                                <button type="submit" class="w-full rounded-xl bg-emerald-600 py-4 text-base font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500 hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2">
                                    <span>Pagar {{ $amount }}€ com MB WAY</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </button>
                                <p class="text-[10px] text-center text-neutral-400 mt-2">Pagamento seguro processado pela Ifthenpay</p>
                            </div>
                        </div>
                    </form>
                @endif

                {{-- ================================================== --}}
                {{-- PASSO 2: SUCESSO --}}
                {{-- ================================================== --}}
                @if($step === 2 && $createdDonation)
                    <div class="p-10 text-center space-y-6">
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 animate-bounce">
                            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-emerald-900">Donativo Confirmado!</h3>
                            <p class="text-sm text-neutral-500 mt-2">Obrigado! A tua ajuda já está a caminho.</p>
                        </div>

                        <div class="bg-neutral-50 p-5 rounded-xl border border-neutral-200 text-left">
                            <p class="text-xs font-bold text-neutral-500 uppercase tracking-wide mb-2">O teu Postal Digital:</p>
                            <div class="flex gap-2">
                                <input type="text" readonly value="{{ route('cards.christmas', $createdDonation->access_code) }}" class="w-full text-sm text-neutral-600 bg-white border-neutral-300 rounded-lg">
                                <a href="{{ route('cards.christmas', $createdDonation->access_code) }}" target="_blank" class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-lg text-sm hover:bg-emerald-700 whitespace-nowrap flex items-center gap-2">
                                    <span>Abrir</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>

                        <button wire:click="$set('showModal', false)" class="text-sm text-neutral-400 underline hover:text-neutral-600">Fechar janela</button>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
