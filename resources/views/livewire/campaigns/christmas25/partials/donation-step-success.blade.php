{{--
    FILE: resources/views/livewire/campaigns/christmas25/partials/donation-step-success.blade.php
--}}

@php
    $isGiftDonation = (bool) data_get($createdDonation->campaign_data, 'is_gift', false);
@endphp

<div class="p-8 text-center space-y-6 animate-in fade-in duration-500">
    <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 mb-4 animate-bounce">
        <svg class="h-8 w-8 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <div>
        <h3 class="text-2xl font-bold text-emerald-900">Pedido enviado</h3>
        <p class="text-sm text-neutral-500 mt-2 max-w-sm mx-auto">
            Enviámos um pedido de pagamento por <strong>MB WAY</strong> para o teu telemóvel.
            Confirma no telemóvel para concluir o pagamento.
        </p>
        <p class="text-xs text-neutral-400 mt-2 max-w-sm mx-auto">
            A prenda ficará validada assim que o pagamento for confirmado.
        </p>
    </div>

    <div class="mt-4 flex flex-col gap-3">
        {{-- Postal do doador --}}
        <a
            href="{{ route('cards.christmas', ['code' => $createdDonation->access_code, 'view' => 'donor']) }}"
            target="_blank"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow transition-colors flex items-center justify-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                </path>
            </svg>
            <span>Ver o meu postal</span>
        </a>

        {{-- Postal para oferecer (se for prenda) --}}
        @if ($isGiftDonation)
            <a
                href="{{ route('cards.christmas', ['code' => $createdDonation->access_code]) }}"
                target="_blank"
                class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow transition-colors flex items-center justify-center gap-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                    </path>
                </svg>
                <span>Postal para oferecer</span>
            </a>

            <p class="text-xs text-neutral-400">
                Copia o link deste postal e envia à pessoa.
            </p>
        @endif
    </div>

    <button
        wire:click="$set('showModal', false)"
        class="text-sm text-neutral-400 underline hover:text-neutral-600 pt-2"
        type="button"
    >
        Fechar janela
    </button>
</div>
