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

<div class="max-w-8xl m-auto my-16">
    <h1>{{ $title }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 my-4 max-w-5xl m-auto my-8">

        @for($i = 0; $i < count($titles); $i++)
            <div class="w-full h-full  overflow-hidden justify-start items-center text-center rounded border-solid border-nrp-blue border">
                <div class="py-1 bg-nrp-blue w-full text-3xl font-extrabold text-white rounded-t">{{ $numbers[$i] }}</div>
                <p class="py-1 font-bold text-center">{{ $titles[$i] }}</p>
            </div>
        @endfor

    </div>
</div>
