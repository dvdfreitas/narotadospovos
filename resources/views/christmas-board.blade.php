<x-guest-layout>
    <div class="max-w-6xl mx-auto px-4 py-6 h-screen max-h-[800px] min-h-[600px] flex flex-col">

        <div class="grid lg:grid-cols-2 gap-6 h-full">

            {{-- COLUNA ESQUERDA: Componente da Árvore --}}
            {{-- O componente já traz o container estilizado --}}
            @livewire('donations.progress')

            {{-- COLUNA DIREITA: Lista de Donativos --}}
            <div class="rounded-3xl border border-emerald-100 bg-white shadow-sm flex flex-col overflow-hidden h-full">

                <div class="p-6 border-b border-emerald-50 bg-white z-10">
                    <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-1">
                        Últimos Donativos
                    </h2>
                    <p class="text-xs text-neutral-500">
                        Obrigado a quem já contribuiu para esta causa.
                    </p>
                </div>

                {{-- Lista com poll para atualizar novos donativos também --}}
                <div
                    class="flex-1 overflow-y-auto p-4 space-y-3 bg-neutral-50/30 scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-transparent hover:scrollbar-thumb-emerald-300">
                    {{-- Adicionei wire:poll.5s também aqui para a lista aparecer sozinha --}}
                    @livewire('donations.latest', ['lazy' => true])
                </div>

                <div class="p-4 border-t border-emerald-50 bg-white">
                    {{-- Usamos Livewire.dispatch para comunicar diretamente com o componente Volt --}}

                    <button type="button" x-data @click="Livewire.dispatch('open-donation-modal')"
                        class="w-full py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">

                        <span>Fazer um Donativo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </button>
                </div>

            </div>

        </div>
    </div>

    {{-- Removemos o <script> manual pois o Livewire trata de tudo --}}
    @livewire('donations.create')
</x-guest-layout>
