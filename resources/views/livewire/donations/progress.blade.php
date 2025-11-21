<?php

use App\Models\Donation;
use function Livewire\Volt\{state, computed};

// CONFIGURAÇÃO
state([
    'goal' => 10000.00 // Define aqui o teu objetivo (1.000€)
]);

// AÇÃO: Atualiza automaticamente a cada 5 segundos
$getDonationStats = computed(function () {
    $total = Donation::sum('amount');

    // Impede divisão por zero e limita a 100%
    $percent = $this->goal > 0
        ? min(100, round(($total / $this->goal) * 100))
        : 0;

    return [
        'total'   => $total,
        'percent' => $percent,
        'remain'  => max(0, $this->goal - $total),
    ];
});

?>

<div wire:poll.5s
     class="relative rounded-3xl border border-emerald-100 bg-gradient-to-b from-emerald-50/80 to-white shadow-sm p-6 flex flex-col overflow-hidden h-full">

    {{-- Cabeçalho --}}
    <header class="text-center z-10 shrink-0">
        <h1 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-2">
            Árvore de Natal Solidária
        </h1>

        {{-- Texto dinâmico --}}
        <p class="text-sm text-neutral-600 max-w-xs mx-auto leading-relaxed">
            @if($this->getDonationStats['percent'] >= 100)
                <span class="font-bold text-emerald-600">Objetivo Alcançado! 🌟</span><br>
                Obrigado pela vossa generosidade extraordinária.
            @else
                Já angariámos <span class="font-bold text-emerald-700">{{ number_format($this->getDonationStats['total'], 2, ',', '.') }}€</span>
                do objetivo de {{ number_format($goal, 0, ',', '.') }}€.
            @endif
        </p>
    </header>

    {{-- ÁREA DA ÁRVORE --}}
    <div class="flex-1 relative w-full min-h-0 my-4 group">

        {{-- 1. Árvore Colorida (Fundo) --}}
        <img src="/images/tree.png"
             class="absolute inset-0 w-full h-full object-contain pointer-events-none z-0"
             alt="Árvore Colorida">

        {{-- 2. Árvore Cinzenta (Topo - Máscara dinâmica) --}}
        {{-- A transição suave (duration-1000) anima a subida quando entra um donativo novo --}}
        <img src="/images/tree.png"
             class="absolute inset-0 w-full h-full object-contain grayscale pointer-events-none z-10 transition-all duration-[2000ms] ease-in-out"
             style="clip-path: inset(0 0 {{ $this->getDonationStats['percent'] }}% 0);"
             alt="Árvore Pendente">

        {{-- Brilho opcional quando completa --}}
        @if($this->getDonationStats['percent'] >= 100)
             <div class="absolute inset-0 bg-yellow-400/10 mix-blend-overlay animate-pulse pointer-events-none z-20"></div>
        @endif
    </div>

    {{-- Barra de Progresso (Rodapé) --}}
    <div class="shrink-0 z-20 bg-white/80 backdrop-blur-sm p-4 rounded-2xl border border-emerald-100/50 mx-auto w-full max-w-sm">

        <div class="flex justify-between items-end mb-2">
            <span class="text-[10px] uppercase tracking-widest text-neutral-500 font-medium">
                Progresso
            </span>
            <div class="text-right">
                <span class="text-2xl font-bold text-emerald-700 leading-none">
                    {{ $this->getDonationStats['percent'] }}%
                </span>
            </div>
        </div>

        {{-- Barra visual --}}
        <div class="w-full bg-emerald-100 rounded-full h-2.5 mb-1 overflow-hidden">
            <div class="bg-emerald-600 h-2.5 rounded-full transition-all duration-[2000ms] ease-out"
                 style="width: {{ $this->getDonationStats['percent'] }}%"></div>
        </div>

        {{-- Texto motivacional --}}
        <p class="mt-2 text-[10px] text-center text-neutral-400">
            @if($this->getDonationStats['percent'] < 100)
                Faltam apenas <strong>{{ number_format($this->getDonationStats['remain'], 2, ',', '.') }}€</strong> para acender a estrela.
            @else
                A estrela brilha graças a ti!
            @endif
        </p>
    </div>

</div>
