<?php
use function Livewire\Volt\{state};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- 1. PAPAS (5€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'papas', amount: 5 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-orange-100 shadow-sm hover:shadow-xl hover:border-orange-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-orange-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🥣
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-orange-600 transition-colors">Papas</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Garante refeições quentes e nutritivas.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-orange-100 text-orange-700 font-bold group-hover:bg-orange-600 group-hover:text-white transition-colors">
            Doar 5€
        </div>
    </button>

    {{-- 2. LEITE DE SUBSTITUIÇÃO (12€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'leite', amount: 12 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-blue-100 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-blue-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🍼
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-blue-600 transition-colors">Leite de Substituição</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Uma lata de leite vital para um bebé.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-blue-100 text-blue-700 font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors">
            Doar 12€
        </div>
    </button>

    {{-- 3. CABAZ (25€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'cabaz', amount: 25 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-purple-100 shadow-sm hover:shadow-xl hover:border-purple-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-purple-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🧺
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-purple-600 transition-colors">Cabaz</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Alimentos e bens essenciais para uma criança.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-purple-100 text-purple-700 font-bold group-hover:bg-purple-600 group-hover:text-white transition-colors">
            Doar 25€
        </div>
    </button>

    {{-- 4. CABAZ FAMÍLIA (50€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'familia', amount: 50 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-red-100 shadow-sm hover:shadow-xl hover:border-red-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-red-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            ❤️
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-red-600 transition-colors">Cabaz Família</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Apoio alimentar alargado para toda a família.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-red-100 text-red-700 font-bold group-hover:bg-red-600 group-hover:text-white transition-colors">
            Doar 50€
        </div>
    </button>

</div>
