<div {{ $attributes->class(['flex flex-wrap items-center justify-between gap-4 rounded-xl border border-sky-100 bg-sky-50/70 p-5 sm:px-6']) }}>
    <div>
        <span class="block text-sm font-semibold text-slate-900">A sua seleção</span>
        <span class="mt-1 block text-sm text-slate-600" x-text="cartUnits === 0 ? 'Escolha os produtos e as quantidades' : cartUnits + (cartUnits === 1 ? ' unidade selecionada' : ' unidades selecionadas')">Escolha os produtos e as quantidades</span>
    </div>
    <div class="flex w-full flex-wrap items-center justify-between gap-4 sm:w-auto sm:gap-6">
        <div>
            <span class="block text-xs text-slate-500">Total</span>
            <span x-text="cartTotal" class="block whitespace-nowrap text-2xl font-semibold tabular-nums text-slate-900">0,00 €</span>
        </div>
        <div class="flex flex-col items-stretch gap-1 sm:flex-row sm:items-center sm:gap-3">
            <button
                type="button"
                x-on:click="openCart()"
                x-bind:disabled="cartUnits === 0"
                x-bind:aria-label="'Comprar seleção: ' + cartUnits + ' unidades, ' + cartTotal"
                aria-haspopup="dialog"
                aria-controls="shop-selection"
                class="inline-flex min-h-12 items-center justify-center gap-2 rounded-lg bg-[#006c94] px-5 text-sm font-semibold text-white hover:bg-[#005575] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94] disabled:cursor-not-allowed disabled:opacity-40"
            >
                Comprar seleção
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round" /></svg>
            </button>
            <button
                type="button"
                x-on:click="clearSelection()"
                class="inline-flex min-h-11 items-center justify-center gap-1.5 rounded-lg px-3 text-sm font-medium text-slate-600 hover:bg-sky-100/70 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94]"
            >
                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M3 5h14M8 5V3h4v2M5 5l1 12h8l1-12M8 8v6m4-6v6" stroke-linecap="round" stroke-linejoin="round" /></svg>
                Limpar tudo
            </button>
        </div>
    </div>
</div>
