<x-guestLayout>

    <x-margins-text>

        @if (session('language') === 'pt')
            <h1>Relatórios</h1>
        @elseif (session('language') === 'en')
            <h1>Reports</h1>
        @endif

        @php
            $years = [2023, 2022, 2021, 2020, 2019, 2018, 2017, 2016];
            $labels = ['Balanço', 'Parecer do Conselho Fiscal', 'Demonstração de Resultados', 'Relatório da Direção'];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols4 gap-3 mt-8">
            @foreach ($years as $year)
                <div class="border-solid p-4 border-2 rounded border-nrp-blue">
                    <div class="text-xl text-nrp-blue font-bold">Ano {{ $year }}</div>
                    @foreach ($labels as $label)
                        @php
                            $file = ".pdf";
                            if ($label == "Balanço") $file = "Balanco_" . $year . $file;
                            elseif ($label == "Parecer do Conselho Fiscal") $file = 'Parecer-Conselho-Fiscal_' . $year . $file;
                            elseif ($label == "Demonstração de Resultados") $file = 'Demonstracao-de-Resultados_'  . $year . $file;
                            elseif ($label == "Relatório da Direção") $file = 'Relatorio-da-Direcao_'  . $year .  $file;
                        @endphp

                        <a href="/docs/relatorios/{{$year}}/{{$file}}">
                            <div class="flex hover:opacity-50 cursor-pointer">
                                <img class="h-12 p-2 " src="/images/icons/pdf.svg">
                                <div class="text-md self-center">{{ $label}}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </x-margins-text>
</x-guestLayout>
