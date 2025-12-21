{{--
    FILE: resources/views/livewire/campaigns/christmas25/board.blade.php
--}}

<?php
use function Livewire\Volt\{state, layout};

// Define the layout explicitly for this full-page component
layout('layouts.guest');

?>

<div> {{-- ROOT ELEMENT (Required by Livewire) --}}

    {{--
        MAIN CONTAINER
    --}}
    <div class="max-w-7xl mx-auto px-4 py-8 min-h-screen flex flex-col gap-12">

        {{-- HEADER SECTION --}}
        <header class="text-center space-y-3">
            <h1 class="text-4xl md:text-5xl font-bold text-emerald-900 tracking-tight drop-shadow-sm">
                Natal Solidário
            </h1>
            <p class="text-neutral-600 max-w-2xl mx-auto text-lg leading-relaxed">
                Choose a gift below and help brighten the Christmas at <span class="font-semibold text-emerald-700">Casa da Mamé</span>.
            </p>
        </header>

        {{-- DASHBOARD GRID --}}
        <main class="grid lg:grid-cols-12 gap-8 lg:h-[750px]">

            {{-- LEFT: Tree --}}
            <section class="lg:col-span-7 h-full min-h-[500px]">
                @livewire('campaigns.christmas25.progress-tree')
            </section>

            {{-- RIGHT: List --}}
            <aside class="lg:col-span-5 h-[600px] lg:h-full flex flex-col bg-white rounded-3xl border border-emerald-100 shadow-sm overflow-hidden">

                <div class="p-6 border-b border-emerald-50 bg-white z-10 shrink-0">
                    <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-1">
                        Latest Gestures
                    </h2>
                    <p class="text-xs text-neutral-500">
                        Thank you to everyone who has contributed.
                    </p>
                </div>

                <div class="flex-1 overflow-y-auto p-4 bg-neutral-50/30 scrollbar-thin scrollbar-thumb-emerald-200 hover:scrollbar-thumb-emerald-300">
                    @livewire('campaigns.christmas25.recent-donations', ['lazy' => true])
                </div>

                <div class="p-4 border-t border-emerald-50 bg-white shrink-0">
                    <button type="button"
                        x-data
                        @click="$dispatch('open-donation-modal')"
                        class="w-full py-4 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <span>Make a Donation</span>
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </button>
                    <p class="text-[10px] text-center text-neutral-400 mt-2">
                        Direct support to ONGD Na Rota dos Povos
                    </p>
                </div>
            </aside>

        </main>

        {{-- DONATION OPTIONS --}}
        <section>
            @livewire('campaigns.christmas25.donation-options')
        </section>

    </div>

    {{-- MODAL (Inside the single root div) --}}
    @livewire('campaigns.christmas25.donation-modal')

</div>
