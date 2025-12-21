<aside class="lg:col-span-5 h-[600px] lg:h-full flex flex-col bg-white rounded-3xl border border-emerald-100 shadow-sm overflow-hidden">

    <div class="p-6 border-b border-emerald-50 bg-white z-10 shrink-0">
        <h2 class="text-xs font-bold uppercase tracking-[0.25em] text-emerald-800 mb-1">
            Últimos donativos
        </h2>
        <p class="text-xs text-neutral-500">
            Obrigado a todos os que contribuíram.
        </p>
    </div>

    <div class="flex-1 overflow-y-auto p-4 bg-neutral-50/30 scrollbar-thin scrollbar-thumb-emerald-200 hover:scrollbar-thumb-emerald-300">
        @livewire('campaigns.christmas25.recent-donations', ['lazy' => true])
    </div>

    <div class="p-4 border-t border-emerald-50 bg-white shrink-0">
        <button
            type="button"
            x-data
            @click="$dispatch('open-donation-modal')"
            class="w-full py-4 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700 hover:shadow-emerald-300 hover:-translate-y-0.5 transition-all duration-300 flex items-center justify-center gap-2 group"
        >
            <span>Fazer um donativo</span>

            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
        </button>

        <p class="text-[10px] text-center text-neutral-400 mt-2">
            Apoio direto à ONGD Na Rota dos Povos
        </p>
    </div>

</aside>
