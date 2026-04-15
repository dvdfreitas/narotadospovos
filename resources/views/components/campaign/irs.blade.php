<section class="max-w-3xl mx-auto my-16">

    <img
        src="/images/campanhas/2026/IRS2026.jpg"
        alt="Consigna 1% do teu IRS - Na Rota dos Povos"
        class="w-full"
    />

    <div class="flex flex-col items-center gap-2 mt-8 px-4">
        <p class="text-gray-400 text-sm uppercase tracking-widest">
            @if (session('language') === 'en')
                Taxpayer number
            @else
                Número de contribuinte
            @endif
        </p>
        <div class="flex items-center gap-4">
            <span class="text-3xl font-bold text-gray-800 tracking-widest">510 878 989</span>
            <button
                onclick="copiarNifCampaign()"
                class="flex items-center gap-2 px-4 py-2 border-2 border-nrp-green text-nrp-green font-semibold rounded-full hover:bg-nrp-green hover:text-white transition-colors text-sm"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16h8M8 12h8m-8-4h4m-6 12h8a2 2 0 002-2V6a2 2 0 00-2-2h-1.586a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 0011.586 2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                </svg>
                @if (session('language') === 'en')
                    Copy
                @else
                    Copiar
                @endif
            </button>
        </div>
        <span id="nif-campaign-copiado" class="text-nrp-green text-sm font-medium invisible mt-1">
            @if (session('language') === 'en')
                Copied to clipboard!
            @else
                Copiado!
            @endif
        </span>
    </div>

</section>

<script>
    function copiarNifCampaign() {
        navigator.clipboard.writeText('510878989').then(function () {
            var aviso = document.getElementById('nif-campaign-copiado');
            aviso.classList.remove('invisible');
            setTimeout(function () { aviso.classList.add('invisible'); }, 2000);
        });
    }
</script>
