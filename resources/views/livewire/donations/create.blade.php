<?php

use App\Models\Donation;
use App\Services\IfthenpayService;
use Illuminate\Support\Str;
use function Livewire\Volt\{state, rules, on};

// =================================================================
// 1. ESTADO (VARIÁVEIS)
// =================================================================
state([
    'showModal' => false,
    'step' => 1,            // Controla se estamos no Formulário (1) ou Sucesso (2)
    'createdDonation' => null, // Guarda o donativo criado para gerar o link

    'amount' => 5,

    // Doador
    'donor_name' => '',
    'donor_email' => '',
    'donor_phone' => '',    // Obrigatório para MB WAY

    // Opções da Árvore
    'is_anonymous' => false,
    'public_message' => '',

    // Opções de Prenda
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
    // Validação simples de telemóvel PT (91, 92, 93, 96)
    'donor_phone' => ['required', 'regex:/^9[1236][0-9]{7}$/'],

    'public_message' => 'nullable|string|max:140',

    'gift_recipient_name' => 'required_if:is_gift,true|nullable|string|max:255',
    'gift_recipient_email' => 'required_if:is_gift,true|nullable|email|max:255',
    'gift_message' => 'nullable|string|max:500',
]);

// =================================================================
// 3. ABRIR MODAL (RESET)
// =================================================================
on(['open-donation-modal' => function () {
    $this->resetValidation();

    // Limpar campos para novo donativo
    $this->donor_name = '';
    $this->donor_email = '';
    $this->donor_phone = '';
    $this->public_message = '';
    $this->is_anonymous = false;
    $this->is_gift = false;
    $this->gift_recipient_name = '';
    $this->gift_recipient_email = '';
    $this->gift_message = '';

    // Reiniciar fluxo
    $this->step = 1;
    $this->createdDonation = null;
    $this->showModal = true;
}]);

// =================================================================
// 4. GUARDAR E PAGAR
// =================================================================
$save = function (IfthenpayService $paymentService) {
    $this->validate();

    // A. Criar registo na BD (Pendente)
    $donation = Donation::create([
        'amount' => $this->amount,
        'donor_name' => $this->donor_name,
        'donor_email' => $this->donor_email,
        'donor_phone' => $this->donor_phone,

        'is_anonymous' => $this->is_anonymous,
        'public_message' => $this->public_message,

        'is_gift' => $this->is_gift,
        'gift_recipient_name' => $this->is_gift ? $this->gift_recipient_name : null,
        'gift_recipient_email' => $this->is_gift ? $this->gift_recipient_email : null,
        'gift_message' => $this->is_gift ? $this->gift_message : null,

        'payment_status' => 'pending',
        'access_code' => Str::random(12),
    ]);

    // B. Comunicar com MB WAY (Simulado ou Real)
    try {
        $result = $paymentService->requestMbWayPayment(
            $this->donor_phone,
            $this->amount,
            $donation->id
        );

        if (isset($result['Estado']) && $result['Estado'] === '000') {
            // SUCESSO NA API

            // Para efeitos de teste/simulação, marcamos já como PAGO
            // (Em produção real, isto seria feito pelo Webhook, mas assim vês logo o resultado)
            $donation->update([
                'payment_status' => 'paid',
                'payment_gateway_id' => $result['IdPedido']
            ]);

            // Guardar dados para o Passo 2
            $this->createdDonation = $donation;

            // Mudar para o ecrã de sucesso
            $this->step = 2;

            // Atualizar a lista lá atrás
            $this->dispatch('donation-added');

        } else {
            // Erro da API (ex: número inválido)
            $this->addError('donor_phone', 'Erro MB WAY: ' . ($result['MsgDescricao'] ?? 'Desconhecido'));
        }

    } catch (\Exception $e) {
        $this->addError('donor_phone', 'Erro técnico: ' . $e->getMessage());
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

        {{-- 1. Backdrop --}}
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-emerald-900/40 backdrop-blur-sm transition-opacity"
             @click="show = false"></div>

        {{-- 2. Layout Central --}}
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">

            {{-- 3. CAIXA DO MODAL --}}
            <div x-show="show"
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-emerald-100">

                {{-- ================================================== --}}
                {{-- PASSO 1: O FORMULÁRIO --}}
                {{-- ================================================== --}}
                @if($step === 1)
                    <div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
                        <h3 class="text-lg font-semibold text-emerald-800 flex items-center gap-2">
                            <span>🎁</span> Fazer Donativo
                        </h3>
                        <button wire:click="$set('showModal', false)" class="text-neutral-400 hover:text-emerald-600">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <form wire:submit="save">
                        <div class="px-6 py-6 space-y-5">

                            {{-- Valor --}}
                            <div>
                                <label class="block text-xs font-medium text-neutral-700 mb-2">Valor do Donativo</label>
                                <div class="grid grid-cols-4 gap-2 mb-3">
                                    @foreach([5, 10, 20, 50] as $val)
                                        <button type="button" wire:click="$set('amount', {{ $val }})"
                                            class="py-2 rounded-lg text-sm font-semibold border transition-all {{ $amount == $val ? 'bg-emerald-600 text-white border-emerald-600 shadow-md' : 'bg-white text-neutral-600 border-neutral-200 hover:bg-emerald-50' }}">
                                            {{ $val }}€
                                        </button>
                                    @endforeach
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500">€</span>
                                    <input type="number" wire:model="amount" step="0.01" min="1"
                                        class="w-full pl-8 pr-4 py-2 rounded-lg border-neutral-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                </div>
                                @error('amount') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>

                            <hr class="border-neutral-100">

                            {{-- Dados Doador --}}
                            <div class="space-y-3">
                                <h4 class="text-xs font-bold text-emerald-800 uppercase">Os teus dados</h4>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <input type="text" wire:model="donor_name" placeholder="O teu Nome" class="w-full text-sm rounded-lg border-neutral-300 focus:ring-emerald-500 focus:border-emerald-500">
                                        @error('donor_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <input type="tel" wire:model="donor_phone" placeholder="Telemóvel (MB WAY)" class="w-full text-sm rounded-lg border-neutral-300 focus:ring-emerald-500 focus:border-emerald-500">
                                        @error('donor_phone') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <input type="email" wire:model="donor_email" placeholder="O teu Email" class="w-full text-sm rounded-lg border-neutral-300 focus:ring-emerald-500 focus:border-emerald-500">
                                @error('donor_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                {{-- Checkbox Anónimo --}}
                                <label class="flex items-center gap-2 cursor-pointer mt-1">
                                    <input type="checkbox" wire:model="is_anonymous" class="rounded text-emerald-600 focus:ring-emerald-600 border-neutral-300">
                                    <span class="text-xs text-neutral-600">Não mostrar o meu nome na árvore</span>
                                </label>
                            </div>

                            <hr class="border-neutral-100">

                            {{-- Mensagem Pública --}}
                            <div>
                                <label class="block text-xs font-medium text-neutral-700 mb-1">Mensagem para a Árvore (Opcional)</label>
                                <input type="text" wire:model="public_message" maxlength="140" placeholder="Ex: Feliz Natal a todos!" class="w-full text-sm rounded-lg border-neutral-300 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>

                            {{-- Prenda --}}
                            <div class="bg-neutral-50 p-3 rounded-xl border border-neutral-200">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-bold text-neutral-800">Oferecer como Prenda?</span>
                                    <button type="button" wire:click="$toggle('is_gift')" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 {{ $is_gift ? 'bg-emerald-600' : 'bg-neutral-300' }}">
                                        <span class="{{ $is_gift ? 'translate-x-6' : 'translate-x-1' }} inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                                    </button>
                                </div>

                                @if($is_gift)
                                    <div class="mt-3 space-y-3 animate-in slide-in-from-top-2">
                                        <input type="text" wire:model="gift_recipient_name" placeholder="Nome do Destinatário" class="w-full text-sm rounded border-emerald-200">
                                        @error('gift_recipient_name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                        <input type="email" wire:model="gift_recipient_email" placeholder="Email do Destinatário" class="w-full text-sm rounded border-emerald-200">
                                        @error('gift_recipient_email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror

                                        <textarea wire:model="gift_message" rows="2" placeholder="Mensagem privada..." class="w-full text-sm rounded border-emerald-200"></textarea>
                                    </div>
                                @endif
                            </div>

                            {{-- Botão Submit --}}
                            <div class="flex flex-row-reverse pt-2">
                                <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 transition-all">
                                    <span wire:loading.remove>Pagar com MB WAY</span>
                                    <span wire:loading>A processar...</span>
                                </button>
                            </div>
                        </div>
                    </form>
                @endif

                {{-- ================================================== --}}
                {{-- PASSO 2: O SUCESSO (Postal) --}}
                {{-- ================================================== --}}
                @if($step === 2 && $createdDonation)
                    <div class="p-10 text-center space-y-6 animate-in zoom-in-95 duration-300">

                        {{-- Ícone Sucesso --}}
                        <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 animate-bounce">
                            <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-2xl font-bold text-emerald-900">Donativo Confirmado!</h3>
                            <p class="text-sm text-neutral-500 mt-2 max-w-xs mx-auto">
                                O teu gesto já coloriu a árvore. Obrigado por ajudares a Casa da Mamé.
                            </p>
                        </div>

                        {{-- Link do Postal --}}
                        <div class="bg-neutral-50 p-5 rounded-xl border border-neutral-200 text-left shadow-inner">
                            <p class="text-xs font-bold text-neutral-500 uppercase tracking-wide mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                O teu Postal Digital:
                            </p>

                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" readonly
                                    value="{{ route('cards.christmas', $createdDonation->access_code) }}"
                                    class="w-full text-sm text-neutral-600 bg-white border-neutral-300 rounded-lg focus:ring-emerald-500 focus:border-emerald-500 select-all">

                                <a href="{{ route('cards.christmas', $createdDonation->access_code) }}" target="_blank"
                                   class="px-5 py-2.5 bg-emerald-600 text-white font-bold rounded-lg text-sm hover:bg-emerald-700 transition-colors whitespace-nowrap flex items-center justify-center gap-2 shadow-sm">
                                    <span>Abrir</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        </div>

                        <button wire:click="$set('showModal', false)" class="text-sm text-neutral-400 hover:text-neutral-600 underline decoration-neutral-300 underline-offset-4 hover:decoration-neutral-500 transition-all">
                            Fechar janela
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
