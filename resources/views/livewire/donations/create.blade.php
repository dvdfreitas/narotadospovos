<?php

use App\Models\Donation;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, on};

state([
    'showModal' => false,
    'amount' => 5,

    // Doador
    'donor_name' => '',
    'donor_email' => '',

    // Árvore
    'is_anonymous' => false,
    'public_message' => '',

    // Oferta
    'is_gift' => false,
    'gift_recipient_name' => '',
    'gift_recipient_email' => '',
    'gift_message' => '',
]);

rules([
    'amount' => 'required|numeric|min:1',
    'donor_name' => 'required|string|max:255',
    'donor_email' => 'required|email|max:255',
    'public_message' => 'nullable|string|max:140',

    // Validação Condicional: Só obrigatório se for gift
    'gift_recipient_name' => 'required_if:is_gift,true|nullable|string|max:255',
    'gift_recipient_email' => 'required_if:is_gift,true|nullable|email|max:255',
    'gift_message' => 'nullable|string|max:500',
]);

// ABRIR MODAL (Ouvinte de evento)
on(['open-donation-modal' => function () {
    $this->resetValidation();

    // CORREÇÃO: Limpar as variáveis corretas do novo State
    $this->donor_name = '';
    $this->donor_email = '';
    $this->is_anonymous = false;
    $this->public_message = '';

    $this->is_gift = false;
    $this->gift_recipient_name = '';
    $this->gift_recipient_email = '';
    $this->gift_message = '';

    // Abre o modal
    $this->showModal = true;
}]);

$save = function () {
    $this->validate();

    Donation::create([
        'amount' => $this->amount,
        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'is_anonymous' => $this->is_anonymous,
        'public_message' => $this->public_message,
        'is_gift' => $this->is_gift,
        'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
        'gift_recipient_email' => $this->is_gift ? $this->gift_recipient_email : null,
        'gift_message' => $this->is_gift ? $this->gift_message : null,
        'access_code' => Str::random(12),
        'show_amount_publicly' => true,
    ]);

    $this->showModal = false;
    $this->dispatch('donation-added');
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
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-emerald-900/40 backdrop-blur-sm transition-opacity"
             @click="show = false"></div>

        {{-- Painel do Modal --}}
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-emerald-100">

                {{-- Cabeçalho Modal --}}
                <div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-emerald-800 flex items-center gap-2">
                        <span>🎁</span> Fazer um Donativo
                    </h3>
                    <button @click="show = false" class="text-neutral-400 hover:text-emerald-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <form wire:submit="save">
                    <div class="px-6 py-6 space-y-6">

                        {{-- 1. SELEÇÃO DE VALOR --}}
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Valor do Donativo</label>

                            {{-- Botões de atalho --}}
                            <div class="grid grid-cols-4 gap-2 mb-3">
                                @foreach([5, 10, 20, 50] as $val)
                                    <button type="button"
                                        wire:click="$set('amount', {{ $val }})"
                                        class="py-2 rounded-lg text-sm font-semibold border transition-all {{ $amount == $val ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-neutral-600 border-neutral-200 hover:border-emerald-300 hover:bg-emerald-50' }}">
                                        {{ $val }}€
                                    </button>
                                @endforeach
                            </div>

                            {{-- Input Manual --}}
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500">€</span>
                                <input type="number" wire:model="amount" step="0.01" min="1"
                                    class="w-full pl-8 pr-4 py-2 rounded-lg border-neutral-300 focus:border-emerald-500 focus:ring-emerald-500">
                            </div>
                            @error('amount') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <hr class="border-neutral-100">

                        {{-- 2. DADOS DO DOADOR --}}
                        <div class="space-y-3">
                            <h4 class="text-sm font-bold text-emerald-800 uppercase tracking-wide">Os teus dados</h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <input type="text" wire:model="donor_name" placeholder="O teu nome"
                                        class="w-full text-sm rounded-lg border-neutral-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    @error('donor_name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <input type="email" wire:model="donor_email" placeholder="O teu email"
                                        class="w-full text-sm rounded-lg border-neutral-300 focus:border-emerald-500 focus:ring-emerald-500">
                                    @error('donor_email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Checkbox Anónimo --}}
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" wire:model="is_anonymous" class="rounded text-emerald-600 focus:ring-emerald-600 border-neutral-300">
                                <span class="text-xs text-neutral-600">Não mostrar o meu nome na árvore (Ficar anónimo)</span>
                            </label>

                            {{-- Mensagem Pública --}}
                            <div>
                                <label class="block text-xs font-medium text-neutral-700 mb-1">Mensagem para a Árvore (Opcional)</label>
                                <input type="text" wire:model="public_message" maxlength="140" placeholder="Ex: Feliz Natal a todos!"
                                    class="w-full text-sm rounded-lg border-neutral-300 focus:border-emerald-500 focus:ring-emerald-500">
                                @error('public_message') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <hr class="border-emerald-100">

                        {{-- 3. PRENDA / OFERTA --}}
                        <div class="bg-neutral-50 p-4 rounded-xl border border-neutral-200">
                            <div class="flex items-center justify-between mb-2">
                                <div>
                                    <span class="text-sm font-bold text-neutral-800">Oferecer como Prenda?</span>
                                    <p class="text-xs text-neutral-500">Enviaremos um cartão digital por email.</p>
                                </div>
                                <button type="button" wire:click="$toggle('is_gift')"
                                    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2 {{ $is_gift ? 'bg-emerald-600' : 'bg-neutral-300' }}">
                                    <span class="{{ $is_gift ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                            </div>

                            @if($is_gift)
                                <div class="space-y-3 pt-2 animate-in slide-in-from-top-2 fade-in">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-neutral-700 mb-1">Nome do Destinatário *</label>
                                            <input type="text" wire:model="gift_recipient_name" class="w-full text-sm rounded-lg border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500">
                                            @error('gift_recipient_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-neutral-700 mb-1">Email do Destinatário *</label>
                                            <input type="email" wire:model="gift_recipient_email" class="w-full text-sm rounded-lg border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500">
                                            @error('gift_recipient_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-neutral-700 mb-1">Mensagem Privada no Email</label>
                                        <textarea wire:model="gift_message" rows="2" placeholder="Ex: Uma pequena lembrança..." class="w-full text-sm rounded-lg border-emerald-200 focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                                        @error('gift_message') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>

                    {{-- RODAPÉ COM BOTÕES --}}
                    <div class="bg-neutral-50 px-6 py-4 flex flex-row-reverse rounded-b-2xl">
                        <button type="submit"
                            class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-emerald-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 sm:ml-3 transition-all">
                            <span wire:loading.remove>Confirmar Donativo</span>
                            <span wire:loading>A processar...</span>
                        </button>
                        <button type="button" @click="show = false" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-3 py-2.5 text-sm font-semibold text-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 hover:bg-neutral-50 sm:mt-0 sm:w-auto transition-all">
                            Cancelar
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
