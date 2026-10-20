@php
    if (session('language') === 'pt') {
        $title = "Os nossos números";

        $titles = [
            'Contentores enviados',
            'Escolas apoiadas',
            'Salas de aula apoiadas',
            'Alunos apoiados',
            'Crianças acolhidas desde 2017',
            'Bolsas de estudo',
            'Bibliotecas',
            'Salas de informática',
            'Postos de trabalho'
        ];


    } elseif (session('language') === 'en') {
        $title = "Our numbers";

        $titles = [
            'Containers sent',
            'Schools supported',
            'Classrooms supported',
            'Students supported',
            'Children welcomed since 2017',
            'Scholarships',
            'Libraries',
            'Computer rooms',
            'Jobs'
        ];

    }

    $numbers = [
            '34',
            '49',
            '220',
            '10.000',
            '30',
            '18',
            '5',
            '2',
            '35'
    ];


@endphp

<div class="max-w-7xl mx-auto px-6 my-10 sm:my-16">
    <h1>{{ $title }}</h1>

    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-6 max-w-5xl mx-auto my-6 sm:my-8">

        @for($i = 0; $i < count($titles); $i++)
            {{-- São 9: em duas colunas o último ocupa a linha toda para não ficar sozinho. --}}
            <div class="flex flex-col overflow-hidden rounded border border-nrp-blue text-center {{ $i === count($titles) - 1 ? 'col-span-2 lg:col-span-1' : '' }}">
                <div class="bg-nrp-blue py-1 text-2xl font-extrabold text-white sm:text-3xl">{{ $numbers[$i] }}</div>
                <p class="my-0 flex flex-1 items-center justify-center px-2 py-1.5 text-sm font-bold leading-tight sm:text-base">{{ $titles[$i] }}</p>
            </div>
        @endfor

    </div>
</div>
