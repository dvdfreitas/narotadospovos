{{--
    FILE: resources/views/livewire/campaigns/christmas25/donation-options.blade.php
--}}

<?php

use function Livewire\Volt\{state};

state([
    // Configuration for the donation cards.
    'options' => [
        [
            'type' => 'papas',
            'amount' => 5,
            'icon_char' => '🥣', // FIXED: changed from 'icon' to 'icon_char'
            'title' => 'Papas',
            'desc' => 'Garante refeições quentes e nutritivas.',
            'color' => 'orange'
        ],
        [
            'type' => 'leite',
            'amount' => 12,
            'icon_char' => '🍼', // FIXED: changed from 'icon' to 'icon_char'
            'title' => 'Leite de Substituição',
            'desc' => 'Uma lata de leite vital para um bebé.',
            'color' => 'blue'
        ],
        [
            'type' => 'cabaz',
            'amount' => 25,
            'icon_char' => '🧺',
            'title' => 'Cabaz',
            'desc' => 'Alimentos e bens essenciais para uma criança.',
            'color' => 'purple'
        ],
        [
            'type' => 'familia',
            'amount' => 50,
            'icon_char' => '❤️',
            'title' => 'Cabaz Família',
            'desc' => 'Apoio alimentar alargado para toda a família.',
            'color' => 'red'
        ]
    ]
]);

?>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

    @foreach($options as $opt)
        <button type="button"
            @click="$dispatch('open-donation-modal', { type: '{{ $opt['type'] }}', amount: {{ $opt['amount'] }} })"
            class="group relative flex flex-col items-center p-6 bg-white rounded-2xl border shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 text-center
            {{-- Dynamic Border Colors --}}
            {{ match($opt['color']) {
                'orange' => 'border-orange-100 hover:border-orange-200',
                'blue'   => 'border-blue-100 hover:border-blue-200',
                'purple' => 'border-purple-100 hover:border-purple-200',
                'red'    => 'border-red-100 hover:border-red-200',
                default  => 'border-gray-100'
            } }}">

            {{-- Icon Circle --}}
            <div class="w-16 h-16 mb-4 rounded-full flex items-center justify-center text-3xl group-hover:scale-110 transition-transform
                {{ match($opt['color']) {
                    'orange' => 'bg-orange-50',
                    'blue'   => 'bg-blue-50',
                    'purple' => 'bg-purple-50',
                    'red'    => 'bg-red-50',
                    default  => 'bg-gray-50'
                } }}">
                {{ $opt['icon_char'] }}
            </div>

            {{-- Text Content --}}
            <h3 class="text-lg font-bold text-neutral-800 transition-colors
                {{ match($opt['color']) {
                    'orange' => 'group-hover:text-orange-600',
                    'blue'   => 'group-hover:text-blue-600',
                    'purple' => 'group-hover:text-purple-600',
                    'red'    => 'group-hover:text-red-600',
                    default  => ''
                } }}">
                {{ $opt['title'] }}
            </h3>

            <p class="text-xs text-neutral-500 mt-1 mb-4 px-2 min-h-[2.5em]">
                {{ $opt['desc'] }}
            </p>

            {{-- CTA Button --}}
            <div class="mt-auto w-full py-2 rounded-lg font-bold transition-colors
                {{ match($opt['color']) {
                    'orange' => 'bg-orange-100 text-orange-700 group-hover:bg-orange-600 group-hover:text-white',
                    'blue'   => 'bg-blue-100 text-blue-700 group-hover:bg-blue-600 group-hover:text-white',
                    'purple' => 'bg-purple-100 text-purple-700 group-hover:bg-purple-600 group-hover:text-white',
                    'red'    => 'bg-red-100 text-red-700 group-hover:bg-red-600 group-hover:text-white',
                    default  => 'bg-gray-100'
                } }}">
                Doar {{ $opt['amount'] }}€
            </div>
        </button>
    @endforeach

</div>
