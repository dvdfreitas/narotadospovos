<?php

use App\Models\Donation;
use Illuminate\Support\Carbon;
use function Livewire\Volt\{state, mount, on};

state([
    'donations' => [],
]);

$loadDonations = function () {
    $this->donations = Donation::orderByDesc('created_at')
        ->take(50)
        ->get()
        ->toArray();
};

mount(function () {
    $this->loadDonations();
});

// Atualiza a lista assim que um donativo novo entra
on(['donation-added' => function () {
    $this->loadDonations();
}]);

?>

<div>
    @forelse ($donations as $donation)
        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-emerald-100 shadow-sm mb-2 transition-all hover:border-emerald-200">

            {{-- Avatar: Usamos ?? false para suportar registos antigos --}}
            <div class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100">
                @if($donation['is_anonymous'] ?? false)
                    {{-- Ícone se Anónimo --}}
                    <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                @else
                    {{-- Inicial do nome --}}
                    {{ strtoupper(substr($donation['donor_name'], 0, 1)) }}
                @endif
            </div>

            {{-- Texto --}}
            <div class="flex-1 min-w-0">

                <div class="flex justify-between items-start gap-2">
                    {{-- Nome do doador --}}
                    <p class="font-semibold text-sm text-neutral-800 leading-tight truncate">
                        @if($donation['is_anonymous'] ?? false)
                            <span class="italic text-neutral-500">Benfeitor Anónimo</span>
                        @else
                            {{ $donation['donor_name'] }}
                        @endif
                    </p>

                    {{-- Tempo relativo (ex: há 5 min) --}}
                    <span class="text-[10px] text-neutral-400 shrink-0 whitespace-nowrap pt-0.5">
                        {{ \Carbon\Carbon::parse($donation['created_at'])->diffForHumans() }}
                    </span>
                </div>

                {{-- MENSAGEM PÚBLICA (A mensagem que aparece na árvore) --}}
                @if (isset($donation['public_message']) && !empty($donation['public_message']))
                    <div class="mt-1 text-xs text-neutral-600 bg-emerald-50/50 p-2 rounded-lg border border-emerald-50 italic">
                        “{{ $donation['public_message'] }}”
                    </div>
                @endif

                {{-- Indicação visual se foi uma Prenda --}}
                @if ($donation['is_gift'] ?? false)
                    <div class="mt-1 flex items-center gap-1 text-[10px] text-emerald-600 font-medium">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                        <span>Oferta de Natal</span>
                    </div>
                @endif
            </div>

            {{-- Valor --}}
            <div class="shrink-0 font-bold text-xs text-emerald-700 bg-emerald-100/50 px-2 py-1 rounded-md border border-emerald-100">
                {{ number_format($donation['amount'], 0, ',', '.') }}€
            </div>

        </div>
    @empty
        <div class="text-center py-8 text-neutral-400 text-xs">
            Ainda não há donativos. Sê o primeiro! 🎄
        </div>
    @endforelse
</div>
