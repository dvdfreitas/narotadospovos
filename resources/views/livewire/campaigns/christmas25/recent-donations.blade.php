<?php

use App\Models\Donation;
use Illuminate\Support\Carbon;
use function Livewire\Volt\{state, mount, on};

// -----------------------------------------------------------------------------
// STATE
// -----------------------------------------------------------------------------

state([
    'donations' => [],
    'limit' => 20,      // Começa por mostrar apenas 20
    'totalCount' => 0,  // Para sabermos se há mais para mostrar
]);

// -----------------------------------------------------------------------------
// LOGIC
// -----------------------------------------------------------------------------

$loadDonations = function () {
    // 1. Contar o total real na BD (para decidir se mostramos o botão)
    $this->totalCount = Donation::where('status', 'paid')->count();

    // 2. Carregar os donativos com o limite atual
    $this->donations = Donation::where('status', 'paid')
        ->orderByDesc('created_at')
        ->take($this->limit)
        ->get()
        ->toArray();
};

/**
 * Aumenta o limite e recarrega a lista.
 */
$loadMore = function () {
    $this->limit += 20; // Carrega mais 20 de cada vez
    $this->loadDonations();
};

mount(function () {
    $this->loadDonations();
});

on(['donation-added' => function () {
    $this->loadDonations();
}]);

?>

<div class="space-y-4">
    <div class="space-y-3">
        @forelse ($donations as $donation)
            @php
                $campaignData = $donation['campaign_data'] ?? [];
                $message = $campaignData['public_message'] ?? null;
                $isGift = $campaignData['is_gift'] ?? false;
                $rawType = $campaignData['item_type'] ?? null;

                $typeName = match ($rawType) {
                    'papas'   => 'Papas',
                    'leite'   => 'Leite Bebé',
                    'crianca' => 'Cabaz Criança',
                    'familia' => 'Cabaz Família',
                    'custom'  => 'Donativo Livre',
                    default   => null,
                };
            @endphp

            {{-- CARD ITEM --}}
            <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-emerald-100 shadow-sm transition-all hover:border-emerald-200 hover:shadow-md animate-in fade-in slide-in-from-bottom-2 duration-500">

                {{-- AVATAR --}}
                <div class="shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-emerald-50 text-emerald-700 font-bold text-xs border border-emerald-100">
                    @if($donation['is_anonymous'] ?? false)
                        <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    @else
                        {{ strtoupper(substr($donation['donor_name'], 0, 1)) }}
                    @endif
                </div>

                {{-- CONTEÚDO --}}
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start gap-2">
                        <p class="font-semibold text-sm text-neutral-800 leading-tight truncate">
                            @if($donation['is_anonymous'] ?? false)
                                <span class="italic text-neutral-500">Benfeitor Anónimo</span>
                            @else
                                {{ $donation['donor_name'] }}
                            @endif
                        </p>

                        <span class="text-[10px] text-neutral-400 shrink-0 whitespace-nowrap pt-0.5">
                            {{ \Carbon\Carbon::parse($donation['created_at'])->diffForHumans() }}
                        </span>
                    </div>

                    @if ($message)
                        <div class="mt-2 text-xs text-neutral-600 bg-emerald-50/50 p-2 rounded-lg border border-emerald-50 italic relative">
                            <span class="absolute -top-1 left-2 text-emerald-200 text-xl leading-none">“</span>
                            <span class="relative z-10 break-words">{{ $message }}</span>
                        </div>
                    @endif

                    <div class="mt-2 flex flex-wrap gap-2">
                        @if ($isGift)
                            <div class="flex items-center gap-1.5 text-[10px] text-purple-600 font-medium bg-purple-50 px-2 py-0.5 rounded-full border border-purple-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                                <span>Presente</span>
                            </div>
                        @endif

                        @if($typeName)
                            <span class="text-[10px] text-neutral-500 bg-neutral-100 px-2 py-0.5 rounded-full border border-neutral-200 uppercase tracking-wide font-medium">
                                {{ $typeName }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- VALOR --}}
                <div class="shrink-0 font-bold text-xs text-emerald-700 bg-emerald-100/50 px-2 py-1 rounded-md border border-emerald-100 h-fit">
                    {{ number_format($donation['amount'], 0, ',', '.') }}€
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-12 text-center space-y-3">
                <div class="w-12 h-12 bg-neutral-50 rounded-full flex items-center justify-center text-2xl grayscale opacity-50">
                    🎄
                </div>
                <div class="text-neutral-400 text-xs">
                    <p>Ainda não há mensagens na árvore.</p>
                    <p>Sê o primeiro a deixar uma!</p>
                </div>
            </div>
        @endforelse
    </div>

    {{-- BOTÃO LOAD MORE --}}
    @if(count($donations) < $totalCount)
        <div class="text-center pt-2">
            <button wire:click="loadMore" class="text-xs font-bold text-emerald-600 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-full transition-colors flex items-center gap-2 mx-auto">
                {{-- Loading Spinner (só aparece enquanto carrega) --}}
                <svg wire:loading wire:target="loadMore" class="animate-spin -ml-1 h-4 w-4 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                {{-- Texto do Botão --}}
                <span wire:loading.remove wire:target="loadMore">Ver mais antigos</span>
                <span wire:loading wire:target="loadMore">A carregar...</span>
                
                {{-- Seta para baixo --}}
                <svg wire:loading.remove wire:target="loadMore" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>
            <p class="text-[10px] text-neutral-400 mt-2">
                A mostrar {{ count($donations) }} de {{ $totalCount }} donativos
            </p>
        </div>
    @endif
</div>