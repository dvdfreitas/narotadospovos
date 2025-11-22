<?php

use App\Models\Donation;
use function Livewire\Volt\{state, computed};

state([
    'goal' => 5000.00,
    // Definimos as posições das bolas manualmente para ficarem bem na árvore
    // top/left em percentagem (%). colors são classes do Tailwind.
    'ornaments' => [
        ['top' => 22, 'left' => 48, 'color' => 'text-red-500'],
        ['top' => 35, 'left' => 38, 'color' => 'text-yellow-400'],
        ['top' => 38, 'left' => 58, 'color' => 'text-blue-500'],
        ['top' => 52, 'left' => 32, 'color' => 'text-pink-500'],
        ['top' => 55, 'left' => 52, 'color' => 'text-red-500'],
        ['top' => 50, 'left' => 68, 'color' => 'text-yellow-400'],
        ['top' => 70, 'left' => 25, 'color' => 'text-blue-400'],
        ['top' => 75, 'left' => 45, 'color' => 'text-purple-500'],
        ['top' => 72, 'left' => 65, 'color' => 'text-red-500'],
        ['top' => 65, 'left' => 78, 'color' => 'text-yellow-400'],
    ]
]);

$getDonationStats = computed(function () {
    $total = Donation::where('payment_status', 'paid')->sum('amount');

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

    {{-- CABEÇALHO --}}
    <header class="text-center z-10 shrink-0 relative">
        <h1 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-2">
            Árvore de Natal Solidária
        </h1>

        <p class="text-sm text-neutral-600 max-w-xs mx-auto leading-relaxed">
            @if($this->getDonationStats['percent'] >= 100)
                <span class="font-bold text-emerald-600">Objetivo Alcançado! 🌟</span><br>
                A Casa da Mamé agradece!
            @else
                Já angariámos <span class="font-bold text-emerald-700">{{ number_format($this->getDonationStats['total'], 0, ',', '.') }}€</span>
                do objetivo de {{ number_format($goal, 0, ',', '.') }}€.
            @endif
        </p>
    </header>

    {{-- ÁREA DA ÁRVORE --}}
    <div class="flex-1 relative w-full min-h-0 my-4 group flex items-end justify-center">

        <div class="relative w-full h-full max-w-[400px]">

            {{-- 1. A ESTRELA (No Topo - Independente das camadas) --}}
            <div class="absolute -top-4 left-1/2 -translate-x-1/2 z-40 transition-all duration-1000"
                 style="width: 50px; height: 50px;">
                <svg viewBox="0 0 24 24" fill="currentColor"
                     class="w-full h-full transition-all duration-1000
                     {{ $this->getDonationStats['percent'] >= 100 ? 'text-yellow-400 drop-shadow-[0_0_15px_rgba(250,204,21,0.8)] animate-pulse' : 'text-neutral-200' }}">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>

            {{-- ==================================================== --}}
            {{-- CAMADA A: COLORIDA (Fundo - Fica por baixo de tudo)  --}}
            {{-- ==================================================== --}}
            <div class="absolute inset-0 z-0">
                {{-- Árvore Colorida --}}
                <img src="/images/tree.png" class="w-full h-full object-contain">

                {{-- Bolas Coloridas (Loop) --}}
                @foreach($ornaments as $ball)
                    <div class="absolute w-4 h-4 {{ $ball['color'] }} drop-shadow-md animate-pulse"
                         style="top: {{ $ball['top'] }}%; left: {{ $ball['left'] }}%; animation-duration: {{ rand(2000, 4000) }}ms;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="14" r="9" /> {{-- Bola --}}
                            <rect x="10" y="2" width="4" height="4" rx="1" fill="#525252"/> {{-- Gancho --}}
                        </svg>
                        {{-- Brilho na bola --}}
                        <div class="absolute top-2 left-1 w-1 h-1 bg-white rounded-full opacity-50"></div>
                    </div>
                @endforeach
            </div>

            {{-- ==================================================== --}}
            {{-- CAMADA B: CINZENTA (Frente - Máscara que encolhe)    --}}
            {{-- ==================================================== --}}
            <div class="absolute inset-0 z-10 pointer-events-none transition-all duration-[2000ms] ease-in-out"
                 style="clip-path: inset(0 0 {{ $this->getDonationStats['percent'] }}% 0);">

                {{-- Árvore Cinzenta --}}
                <img src="/images/tree.png" class="w-full h-full object-contain grayscale opacity-90">

                {{-- Bolas Cinzentas (Loop - Mesmas posições, cor cinza) --}}
                @foreach($ornaments as $ball)
                    <div class="absolute w-4 h-4 text-neutral-300"
                         style="top: {{ $ball['top'] }}%; left: {{ $ball['left'] }}%;">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <circle cx="12" cy="14" r="9" />
                            <rect x="10" y="2" width="4" height="4" rx="1" fill="#a3a3a3"/>
                        </svg>
                    </div>
                @endforeach
            </div>


            {{-- 4. ITEMS NA BASE (Z-20 para ficar à frente da árvore colorida) --}}
            <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-full flex justify-center items-end z-20 pointer-events-none pb-2">

                {{-- Lata Trás --}}
                <div class="absolute left-[20%] bottom-3 w-10 h-12 z-10 opacity-90 transform -rotate-12">
                     <svg viewBox="0 0 40 50" fill="none" class="drop-shadow-sm">
                        <rect x="5" y="10" width="30" height="38" rx="2" fill="#cbd5e1"/>
                        <rect x="5" y="18" width="30" height="22" fill="#e2e8f0"/>
                        <rect x="4" y="8" width="32" height="4" rx="1" fill="#94a3b8"/>
                        <path d="M15 25h10" stroke="#94a3b8" stroke-width="2"/>
                    </svg>
                </div>

                {{-- Caixa Trás --}}
                <div class="absolute right-[22%] bottom-3 w-12 h-14 z-10 opacity-90 transform rotate-6">
                    <svg viewBox="0 0 50 60" fill="none" class="drop-shadow-sm">
                        <rect x="10" y="10" width="30" height="45" rx="1" fill="#fca5a5"/>
                        <rect x="10" y="25" width="30" height="15" fill="#fecaca"/>
                        <circle cx="25" cy="32" r="5" fill="#fef08a"/>
                    </svg>
                </div>

                {{-- Prenda Esquerda --}}
                <div class="relative -mr-3 z-20 transform -rotate-6">
                    <svg class="w-10 h-10 text-red-600 drop-shadow-md" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 12v10H4V12h16zm-2-2H6V6h12v4zm-7-6V2h2v2h-2z"/>
                        <rect x="2" y="8" width="20" height="4" rx="1" fill="#fca5a5"/>
                        <rect x="4" y="12" width="16" height="10" rx="1" fill="#ef4444"/>
                        <rect x="11" y="8" width="2" height="14" fill="#fee2e2"/>
                    </svg>
                </div>

                {{-- Prenda Central --}}
                <div class="relative z-30 mb-1">
                    <svg class="w-14 h-14 text-emerald-600 drop-shadow-lg" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="8" width="18" height="4" rx="1" fill="#6ee7b7"/>
                        <rect x="5" y="12" width="14" height="10" rx="1" fill="#059669"/>
                        <path d="M12 8V22" stroke="#d1fae5" stroke-width="3"/>
                        <path d="M12 8C12 8 8 3 6 5C4 7 12 8 12 8Z" fill="#a7f3d0"/>
                        <path d="M12 8C12 8 16 3 18 5C20 7 12 8 12 8Z" fill="#a7f3d0"/>
                    </svg>
                </div>

                {{-- Prenda Direita --}}
                <div class="relative -ml-3 z-20 transform rotate-3">
                    <svg class="w-9 h-9 text-blue-600 drop-shadow-md" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="9" width="18" height="3" rx="0.5" fill="#93c5fd"/>
                        <rect x="5" y="12" width="14" height="9" rx="0.5" fill="#2563eb"/>
                        <rect x="11" y="9" width="2" height="12" fill="#dbeafe"/>
                    </svg>
                </div>

            </div>

        </div>
    </div>

    {{-- BARRA DE PROGRESSO --}}
    <div class="shrink-0 z-20 bg-white/90 backdrop-blur-sm p-4 rounded-2xl border border-emerald-100/50 mx-auto w-full max-w-sm shadow-sm mt-auto">
        <div class="flex justify-between items-end mb-2">
            <span class="text-[10px] uppercase tracking-widest text-neutral-500 font-medium">Progresso</span>
            <div class="text-right">
                <span class="text-2xl font-bold text-emerald-700 leading-none">{{ $this->getDonationStats['percent'] }}%</span>
            </div>
        </div>
        <div class="w-full bg-neutral-100 rounded-full h-3 mb-1 overflow-hidden border border-neutral-100 relative">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-3 rounded-full transition-all duration-[2000ms] ease-out relative"
                 style="width: {{ $this->getDonationStats['percent'] }}%">
                 <div class="absolute inset-0 bg-white/20"></div>
            </div>
        </div>
        <p class="mt-2 text-[10px] text-center text-neutral-400">
            @if($this->getDonationStats['percent'] < 100)
                Faltam <strong>{{ number_format($this->getDonationStats['remain'], 0, ',', '.') }}€</strong> para acender a estrela.
            @else
                Objetivo cumprido! Obrigado! ❤️
            @endif
        </p>
    </div>

</div>
