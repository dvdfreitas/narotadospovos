<?php
use function Livewire\Volt\{state};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    {{-- 1. BENS ALIMENTARES (5€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'food', amount: 5 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-orange-100 shadow-sm hover:shadow-xl hover:border-orange-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-orange-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🥣
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-orange-600 transition-colors">Bens Alimentares</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Ajuda a garantir papas e refeições essenciais.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-orange-100 text-orange-700 font-bold group-hover:bg-orange-600 group-hover:text-white transition-colors">
            Doar 5€
        </div>
    </button>

    {{-- 2. LEITE DE SUBSTITUIÇÃO (12€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'milk', amount: 12 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-blue-100 shadow-sm hover:shadow-xl hover:border-blue-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-blue-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🍼
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-blue-600 transition-colors">Leite de Bebé</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Uma lata de leite de substituição vital.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-blue-100 text-blue-700 font-bold group-hover:bg-blue-600 group-hover:text-white transition-colors">
            Doar 12€
        </div>
    </button>

    {{-- 3. KIT HIGIENE (20€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'hygiene', amount: 20 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-purple-100 shadow-sm hover:shadow-xl hover:border-purple-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="w-16 h-16 mb-4 rounded-full bg-purple-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            🧼
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-purple-600 transition-colors">Kit Higiene</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Fraldas, toalhitas e produtos de limpeza.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-purple-100 text-purple-700 font-bold group-hover:bg-purple-600 group-hover:text-white transition-colors">
            Doar 20€
        </div>
    </button>

    {{-- 4. CABAZ FAMÍLIA (50€) --}}
    <button type="button"
        @click="Livewire.dispatch('open-donation-modal', { type: 'family', amount: 50 })"
        class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border border-red-100 shadow-sm hover:shadow-xl hover:border-red-200 hover:-translate-y-1 transition-all duration-300 text-center">

        <div class="absolute top-3 right-3">
            <span class="flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
            </span>
        </div>

        <div class="w-16 h-16 mb-4 rounded-full bg-red-50 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
            ❤️
        </div>
        <h3 class="text-lg font-bold text-neutral-800 group-hover:text-red-600 transition-colors">Cabaz Família</h3>
        <p class="text-xs text-neutral-500 mt-1 mb-4 px-2">Apoio alimentar completo para uma família.</p>

        <div class="mt-auto w-full py-2 rounded-lg bg-red-100 text-red-700 font-bold group-hover:bg-red-600 group-hover:text-white transition-colors">
            Doar 50€
        </div>
    </button>

</div>
