{{--
    FILE: resources/views/livewire/campaigns/christmas25/partials/donation-step-form.blade.php
--}}

<div class="bg-emerald-50/50 px-6 py-4 border-b border-emerald-100 flex justify-between items-center">
    <h3 class="text-lg font-semibold text-emerald-800 flex items-center gap-2">
        <span>🎁</span> Escolhe o teu impacto
    </h3>

    <button wire:click="$set('showModal', false)" class="text-neutral-400 hover:text-emerald-600" type="button">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</div>

<form wire:submit="save">
    <div class="px-6 py-6 space-y-6">

        {{-- Produtos --}}
        <div>
            <label class="block text-xs font-bold uppercase tracking-widest text-neutral-500 mb-3">
                O que queres oferecer?
            </label>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach ($products as $p)
                    <button
                        type="button"
                        wire:click="selectProduct('{{ $p['type'] }}', {{ $p['amount'] }})"
                        class="relative flex items-center p-3 rounded-xl border-2 transition-all text-left group hover:shadow-md
                            {{ $selectedProduct === $p['type'] ? $p['selected'] : $p['idle'] }}"
                    >
                        <div class="h-12 w-12 flex-shrink-0 rounded-full flex items-center justify-center text-xl mr-3 {{ $p['icon'] }}">
                            {{ $p['emoji'] }}
                        </div>

                        <div>
                            <p class="font-bold text-neutral-800">{{ $p['title'] }}</p>
                            <p class="text-xs text-neutral-500">{{ $p['desc'] }}</p>
                        </div>

                        <div class="ml-auto font-bold text-lg {{ $p['price'] }}">{{ $p['amount'] }}€</div>
                    </button>
                @endforeach
            </div>

            {{-- Valor livre --}}
            <div class="mt-3 relative" @click="$wire.set('selectedProduct', 'custom')">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-neutral-500 font-bold">€</span>
                <input
                    type="number"
                    wire:model="amount"
                    step="0.01"
                    min="1"
                    class="w-full pl-8 pr-4 py-3 rounded-xl border-2 focus:ring-emerald-500 focus:border-emerald-500 text-lg font-bold
                        {{ $selectedProduct === 'custom' ? 'border-emerald-500 bg-emerald-50/30' : 'border-neutral-200' }}"
                >
            </div>

            @error('amount')
                <span class="text-xs text-red-500 font-bold block mt-1">{{ $message }}</span>
            @enderror
        </div>

        {{-- Dados --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-3">
                <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide">
                    Os teus dados
                </label>

                <input
                    type="text"
                    wire:model="donor_name"
                    placeholder="O teu nome"
                    class="w-full text-sm rounded-lg border-neutral-300"
                >
                @error('donor_name')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror

                <input
                    type="email"
                    wire:model="donor_email"
                    placeholder="Email (para o recibo)"
                    class="w-full text-sm rounded-lg border-neutral-300"
                >
                @error('donor_email')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <input
                            type="tel"
                            wire:model="donor_phone"
                            placeholder="Telemóvel (MB WAY)"
                            class="w-full text-sm rounded-lg border-neutral-300"
                        >
                        @error('donor_phone')
                            <span class="text-xs text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <input
                            type="text"
                            wire:model="nif"
                            placeholder="NIF (opcional)"
                            maxlength="9"
                            class="w-full text-sm rounded-lg border-neutral-300"
                        >
                    </div>
                </div>

                @error('nif')
                    <span class="text-xs text-red-500">{{ $message }}</span>
                @enderror

                <label class="flex items-center gap-2 cursor-pointer pt-1">
                    <input type="checkbox" wire:model="is_anonymous" class="rounded text-emerald-600 border-neutral-300">
                    <span class="text-xs text-neutral-600">Doar como anónimo</span>
                </label>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-neutral-700 uppercase tracking-wide mb-1">
                        Mensagem pública
                    </label>
                    <textarea
                        wire:model="public_message"
                        rows="2"
                        placeholder="Deixa uma mensagem na árvore..."
                        class="w-full text-sm rounded-lg border-neutral-300"
                    ></textarea>
                    @error('public_message')
                        <span class="text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="bg-neutral-50 p-3 rounded-lg border border-neutral-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs font-bold text-neutral-700">É um presente? 🎁</span>

                        <button
                            type="button"
                            wire:click="$toggle('is_gift')"
                            class="{{ $is_gift ? 'bg-emerald-600' : 'bg-neutral-300' }} relative inline-flex h-5 w-9 rounded-full transition-colors"
                        >
                            <span
                                class="{{ $is_gift ? 'translate-x-4' : 'translate-x-1' }} inline-block h-3 w-3 transform rounded-full bg-white transition-transform mt-1"
                            ></span>
                        </button>
                    </div>

                    @if ($is_gift)
                        <div class="space-y-2 animate-in fade-in">
                            <input
                                type="text"
                                wire:model="gift_recipient_name"
                                placeholder="Nome do destinatário"
                                class="w-full text-xs rounded border-neutral-300"
                            >
                            @error('gift_recipient_name')
                                <span class="text-xs text-red-500 block">{{ $message }}</span>
                            @enderror

                            <textarea
                                wire:model="gift_message"
                                rows="2"
                                placeholder="Mensagem para o postal..."
                                class="w-full text-xs rounded border-neutral-300"
                            ></textarea>
                            @error('gift_message')
                                <span class="text-xs text-red-500 block">{{ $message }}</span>
                            @enderror

                            <p class="text-[10px] text-emerald-700 italic bg-emerald-50 p-1.5 rounded">
                                Receberás um link do postal para enviares à pessoa.
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- RGPD --}}
        <div class="pt-2 border-t border-gray-100">
            <label class="flex items-start gap-2 cursor-pointer">
                <input
                    type="checkbox"
                    wire:model="terms"
                    class="mt-1 rounded text-emerald-600 border-neutral-300 focus:ring-emerald-500"
                >
                <div class="text-xs text-neutral-500">
                    Aceito a
                    <a
                        href="{{ route('christmas.privacy') }}"
                        target="_blank"
                        class="font-bold text-emerald-700 hover:underline"
                    >
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
                <span class="text-xs text-red-500 font-bold block mt-1 ml-6">{{ $message }}</span>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full rounded-xl bg-emerald-600 py-4 text-base font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-500 hover:-translate-y-0.5 transition-all flex justify-center items-center gap-2"
        >
            <span>Pagar {{ $amount }}€ com MB WAY</span>
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </button>

        <p class="text-[10px] text-center text-neutral-400 mt-2">
            Pagamento seguro processado pela Ifthenpay.
        </p>
    </div>
</form>
