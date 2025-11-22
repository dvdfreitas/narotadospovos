<x-guest-layout>

    {{--
        CONTAINER PRINCIPAL
        min-h-screen: Garante que ocupa o ecrã todo, mas cresce se preciso.
        pb-12: Dá espaço em baixo para não colar ao footer.
    --}}
    <div class="max-w-6xl mx-auto px-4 py-8 min-h-screen flex flex-col gap-10">

        {{-- TÍTULO / INTRODUÇÃO (Opcional, fica bem visualmente) --}}
        <div class="text-center space-y-2">
            <h1 class="text-3xl md:text-4xl font-bold text-emerald-900 tracking-tight">
                Natal Solidário
            </h1>
            <p class="text-neutral-600 max-w-2xl mx-auto">
                Escolha um presente abaixo e ajude a iluminar o Natal da Casa da Mamé.
            </p>
        </div>

        {{-- 1. ZONA DOS CARTÕES (ATALHOS) --}}

        {{--
            2. GRID PRINCIPAL (ÁRVORE + LISTA)
            lg:h-[750px]: Em desktop, fixamos a altura para a árvore e a lista ficarem iguais.
            Isto força a lista a ter scroll interno.
        --}}
        <div class="grid lg:grid-cols-2 gap-8 lg:h-[750px]">

            {{-- COLUNA ESQUERDA: Árvore (Ocupa 100% da altura do pai) --}}
            @livewire('donations.progress')

            {{-- COLUNA DIREITA: Lista de Donativos --}}
            <div class="rounded-3xl border border-emerald-100 bg-white shadow-sm flex flex-col overflow-hidden h-[600px] lg:h-full">

                {{-- Cabeçalho da Lista --}}
                <div class="p-6 border-b border-emerald-50 bg-white z-10 shrink-0">
                    <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-1">
                        Últimos Gestos
                    </h2>
                    <p class="text-xs text-neutral-500">
                        Obrigado a quem já contribuiu para esta causa.
                    </p>
                </div>

                {{--
                    CORPO DA LISTA (SCROLLÁVEL)
                    flex-1: Ocupa todo o espaço disponível restante.
                    overflow-y-auto: Cria a barra de scroll se a lista for grande.
                --}}
                <div class="flex-1 overflow-y-auto p-4 space-y-3 bg-neutral-50/30 scrollbar-thin scrollbar-thumb-emerald-200 scrollbar-track-transparent hover:scrollbar-thumb-emerald-300">
                    @livewire('donations.latest', ['lazy' => true])
                </div>

                {{-- RODAPÉ DA LISTA (Botão Genérico) --}}
                <div class="p-4 border-t border-emerald-50 bg-white shrink-0">
                    {{-- Botão que abre o modal sem valores pré-definidos --}}
                    <button type="button"
                        x-data
                        @click="Livewire.dispatch('open-donation-modal')"
                        class="w-full py-3 rounded-xl bg-emerald-600 text-white font-semibold shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2">
                        <span>Fazer um Donativo</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                            </path>
                        </svg>
                    </button>
                    <p class="text-[10px] text-center text-neutral-400 mt-2">
                        Apoio direto à ONGD Na Rota dos Povos
                    </p>
                </div>

            </div>

        </div>
         <div>
            @livewire('donations.cards')
        </div>

    </div>

    {{-- O MODAL (Fica fora do fluxo visual, no fim da página) --}}
    @livewire('donations.create')

</x-guest-layout>
