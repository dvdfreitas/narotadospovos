<?php

use App\Models\Donation;
use App\Services\IfthenpayService;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, on};

// =================================================================
// 1. LÓGICA (PHP)
// =================================================================
state([
    'showModal' => false,
    'step' => 1,
    'createdDonation' => null,
    'amount' => 5,
    'selectedProduct' => 'papas',

    // Dados do Doador
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

// Abrir o Modal
on(['open-donation-modal' => function ($type = 'papas', $amount = 5) {
    $this->resetValidation();
    $this->reset(['donor_name', 'donor_email', 'donor_phone', 'nif', 'public_message', 'gift_recipient_name', 'gift_recipient_email', 'gift_message', 'createdDonation']);

    $this->is_anonymous = false;
    $this->is_gift = false;

    $this->selectedProduct = $type;
    $this->amount = $amount;
    $this->step = 1;
    $this->showModal = true;
}]);

// Helper para selecionar produto
$selectProduct = function($type, $value) {
    $this->selectedProduct = $type;
    $this->amount = $value;
};

// Gravar e Pagar
$save = function (IfthenpayService $paymentService) {
    $this->validate(null, [
        'donor_phone.required' => 'O telemóvel é necessário para o MB WAY.',
        'donor_phone.regex' => 'Introduza um número válido (91, 92, 93 ou 96).',
    ]);

    // Criação do Donativo
    $donation = Donation::create([
        'amount' => $this->amount,
        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'donor_phone' => $this->donor_phone,
        'nif' => $this->nif ?: null,
        'is_anonymous' => (bool) $this->is_anonymous,
        'public_message' => $this->public_message,
        'is_gift' => (bool) $this->is_gift,
        'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
        'gift_recipient_email' => $this->is_gift ? $this->gift_recipient_email : null,
        'gift_message' => $this->is_gift ? $this->gift_message : null,
        'payment_status' => 'pending',
        'access_code' => Str::random(12),
    ]);

    try {
        $result = $paymentService->requestMbWayPayment($this->donor_phone, $this->amount, $donation->id);

        if (isset($result['Estado']) && $result['Estado'] === '000') {
            // SUCESSO
            $donation->update(['payment_status' => 'paid', 'payment_gateway_id' => $result['IdPedido']]);

            $this->createdDonation = $donation;
            $this->step = 2;
            $this->dispatch('donation-added');
        } else {
            $this->addError('donor_phone', 'Erro MB WAY: ' . ($result['MsgDescricao'] ?? 'Tente novamente.'));
        }
    } catch (\Exception $e) {
        $this->addError('donor_phone', 'Erro técnico de comunicação.');
    }
};
?>

{{-- ================================================================= --}}
{{-- 2. HTML (VIEW) --}}
{{-- ================================================================= --}}
<div>
    {{-- MODAL CONTAINER --}}
    <div x-data="{ show: @entangle('showModal').live }"
         x-show="show"
         x-on:keydown.escape.window="show = false"
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        {{-- Backdrop --}}
        <div x-show="show" class="fixed inset-0 bg-emerald-950/40 backdrop-blur-sm transition-opacity" @click="show = false"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-emerald-100">

                {{-- ================================================== --}}
                {{-- PASSO 1: FORMULÁRIO --}}
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
                                    {{-- 5€ PAPAS --}}
                                    <button type="button" wire:click="selectProduct('papas', 5)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'papas' ? 'border-orange-400 bg-orange-50 ring-1 ring-orange-400' : 'border-neutral-200 bg-white hover:border-orange-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl mr-3">🥣</div>
                                        <div><p class="font-bold text-neutral-800">Papas</p><p class="text-xs text-neutral-500">Refeições quentes.</p></div>
                                        <div class="ml-auto font-bold text-orange-700 text-lg">5€</div>
                                    </button>

                                    {{-- 12€ LEITE --}}
                                    <button type="button" wire:click="selectProduct('leite', 12)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'leite' ? 'border-blue-400 bg-blue-50 ring-1 ring-blue-400' : 'border-neutral-200 bg-white hover:border-blue-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl mr-3">🍼</div>
                                        <div><p class="font-bold text-neutral-800">Leite Bebé</p><p class="text-xs text-neutral-500">Lata essencial.</p></div>
                                        <div class="ml-auto font-bold text-blue-700 text-lg">12€</div>
                                    </button>

                                    {{-- 25€ CRIANÇA --}}
                                    <button type="button" wire:click="selectProduct('crianca', 25)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'crianca' ? 'border-purple-400 bg-purple-50 ring-1 ring-purple-400' : 'border-neutral-200 bg-white hover:border-purple-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center text-xl mr-3">🧸</div>
                                        <div><p class="font-bold text-neutral-800">Cabaz Criança</p><p class="text-xs text-neutral-500">Higiene e bens.</p></div>
                                        <div class="ml-auto font-bold text-purple-700 text-lg">25€</div>
                                    </button>

                                    {{-- 50€ FAMÍLIA --}}
                                    <button type="button" wire:click="selectProduct('familia', 50)"
                                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md {{ $selectedProduct === 'familia' ? 'border-red-400 bg-red-50 ring-1 ring-red-400' : 'border-neutral-200 bg-white hover:border-red-200' }}">
                                        <div class="h-12 w-12 flex-shrink-0 bg-red-100 text-red-600 rounded-full flex items-center justify-center text-xl mr-3">❤️</div>
                                        <div><p class="font-bold text-neutral-800">Cabaz Família</p><p class="text-xs text-neutral-500">Apoio mensal.</p></div>
                                        <div class="ml-auto font-bold text-red-700 text-lg">50€</div>
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

                            {{-- INPUTS DADOS --}}
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide">Os teus dados</label>

                                    <input type="text" wire:model="donor_name" placeholder="O teu Nome" class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                    <input type="email" wire:model="donor_email" placeholder="Email" class="w-full text-sm rounded-lg border-neutral-300">
                                    @error('donor_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="tel" wire:model="donor_phone" placeholder="Telemóvel (MB)" class="w-full text-sm rounded-lg border-neutral-300">
                                            @error('donor_phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="nif" placeholder="NIF (Opcional)" maxlength="9" class="w-full text-sm rounded-lg border-neutral-300">
                                        </div>
                                    </div>
                                    @error('nif') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                    <label class="flex items-center gap-2 cursor-pointer pt-1">
                                        <input type="checkbox" wire:model="is_anonymous" class="rounded text-emerald-600 border-neutral-300">
                                        <span class="text-xs text-neutral-600">Doar como Anónimo</span>
                                    </label>
                                </div>

                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide mb-1">Mensagem Pública</label>
                                        <textarea wire:model="public_message" rows="2" placeholder="Deixa uma mensagem na árvore..." class="w-full text-sm rounded-lg border-neutral-300"></textarea>
                                    </div>

                                    {{-- PRENDA --}}
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
                                                @error('gift_recipient_name') <span class="text-xs text-red-500 block">{{ $message }}</span> @enderror

                                                <input type="email" wire:model="gift_recipient_email" placeholder="Email do Destinatário" class="w-full text-xs rounded border-neutral-300">
                                                <textarea wire:model="gift_message" rows="2" placeholder="Mensagem privada..." class="w-full text-xs rounded border-neutral-300"></textarea>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full rounded-xl bg-emerald-600 py-4 text-base font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500 hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2">
                                <span>Pagar {{ $amount }}€ com MB WAY</span>
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </button>
                            <p class="text-[10px] text-center text-neutral-400 mt-2">Pagamento seguro processado pela Ifthenpay</p>
                        </div>
                    </form>
                @endif

                {{-- ================================================== --}}
                {{-- PASSO 2: SUCESSO (AGORA COM BOTÕES SÓLIDOS IGUAIS) --}}
                {{-- ================================================== --}}
                @if($step === 2 && $createdDonation)
                    <div class="p-8 text-center space-y-6 animate-in fade-in duration-500">

                        {{-- Ícone Sucesso --}}
                        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4 animate-bounce">
                            <svg class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-emerald-900">Donativo Confirmado!</h3>
                            <p class="text-sm text-neutral-500 mt-2 max-w-xs mx-auto">
                                Obrigado! O teu apoio já chegou à Casa da Mamé.<br>
                                <span class="text-xs font-medium text-emerald-600 block mt-1">
                                    (Enviámos também estes links para o teu email)
                                </span>
                            </p>
                        </div>

                        <div class="space-y-3 text-left">

                            {{-- CARTÃO 1: DOADOR (AGORA COM FUNDO AZUL e BOTÃO SÓLIDO) --}}
                            <div class="flex items-center justify-between p-4 bg-blue-50 border border-blue-200 rounded-xl shadow-sm hover:border-blue-300 transition-colors">
                                <div class="flex items-center gap-4">
                                    {{-- Ícone Azul em fundo branco --}}
                                    <div class="flex items-center justify-center w-10 h-10 bg-white rounded-full text-blue-600 shadow-sm">
                                        {{-- Ícone de Coração para ser mais "quente" --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-[10px] font-bold tracking-widest text-blue-500 uppercase">Para Ti</p>
                                        <p class="text-sm font-bold text-blue-900">O teu Agradecimento</p>
                                    </div>
                                </div>

                                {{-- Botão Sólido Azul (igual ao de baixo) --}}
                                <a href="{{ route('cards.christmas', ['code' => $createdDonation->access_code, 'view' => 'donor']) }}" target="_blank"
                                class="h-10 px-4 flex items-center gap-2 bg-blue-600 text-white font-bold rounded-lg text-xs hover:bg-blue-700 shadow-md hover:shadow-lg transition-all">
                                    <span>Abrir</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>

                            {{-- CARTÃO 2: DESTINATÁRIO --}}
                            @if($createdDonation->is_gift)
                                <div class="relative overflow-hidden flex items-center justify-between p-4 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm hover:border-emerald-300 transition-colors group">

                                    <div class="absolute -right-2 -top-2 text-emerald-100/50 text-5xl pointer-events-none group-hover:scale-110 transition-transform">🎁</div>

                                    <div class="relative z-10 flex items-center gap-4">
                                        <div class="flex items-center justify-center w-10 h-10 bg-white rounded-full text-emerald-600 shadow-sm">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-[10px] font-bold tracking-widest text-emerald-600 uppercase">Oferta Para</p>
                                            <p class="text-sm font-bold text-emerald-900 truncate max-w-[140px]">
                                                {{ Str::limit($createdDonation->gift_recipient_name, 18) }}
                                            </p>
                                        </div>
                                    </div>

                                    <a href="{{ route('cards.christmas', ['code' => $createdDonation->access_code]) }}" target="_blank"
                                    class="relative z-10 h-10 px-4 flex items-center gap-2 bg-emerald-600 text-white font-bold rounded-lg text-xs hover:bg-emerald-700 shadow-md hover:shadow-lg transition-all">
                                        <span>Abrir</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    </a>
                                </div>
                                <p class="text-[10px] text-center text-neutral-400 mt-2">
                                    Copia o link do "Postal" e envia por WhatsApp.
                                </p>
                            @endif
                        </div>

                        <button wire:click="$set('showModal', false)" class="text-sm text-neutral-400 underline hover:text-neutral-600 pt-2">
                            Fechar janela
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
