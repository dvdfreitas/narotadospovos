<x-guestLayout>

    <x-banner-image image="/images/projects/academy/academy1.jpg" />

    <x-margins-text>
        @if (session('language') === 'pt')
            <h1>Academia desportiva</h1>
        @elseif (session('language') === 'en')
            <h1>Sports Academy</h1>
        @endif

        @if (session('language') === 'pt')
            <p>Na nossa <span class="text-nrp-blue">Academia Desportiva "Na Rota dos Povos"</span> temos inscritos mais de 60 jovens, incluindo 20 meninas, que se dedicam ao treino e formação em futebol, sendo um estimulo ao seu bom aproveitamento escolar.</p>
        @elseif (session('language') === 'en')
            <p>In our <span class="text-nrp-blue">Sports Academy "Na Rota dos Povos"</span> we have more than 60 young people enrolled, including 20 girls, who dedicate themselves to training and education in football, being a stimulus to their good school performance.</p>
        @endif
    </x-margins-text>
</x-guestLayout>
