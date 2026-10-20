@php

    $titles = [];
    $descriptions = [];
    $images = [
            'education.jpg',
            'mame.jpg',
            'ceet.jpg',
            'health.jpg'
    ];

    $links = [
        route('projects.education'),
        route('projects.mame'),
        route('projects.ceet'),
        route('projects.health'),
    ];

    if (session('language') === 'pt') {
        $titles = [
            'Apoio à Educação',
            'Casa da Mamé',
            'Centro de Educação Especial e Terapêutica (CEET)',
            'Apoio à Saúde'
        ];

        $descriptions = [
            'Temos apoiado 49 escolas, equipando 220 salas de aula e fornecemos material escolar a 10 000 alunos da região de Tombali. Montamos 5 bibliotecas e uma biblioteca itineranate',
            'A Casa da Mamé é uma casa coração que acolhe crianças cuja mãe morreu no parto. Permite-lhes acesso a alimentação, cuidados de saúde, educação e amor. É um verdadeiro lar.',
            'O CEET é um centro clínico dedicado ao diagnóstico, tratamento e melhoria da qualidade de vida de crianças com deficiência.',
            'Apoiamos o Hospital de Catió e Centros de Saúde da região de Tombali com apoio médico equipamento e material hospitalar e medicamentos.'
        ];


    } elseif (session('language') === 'en') {
        $titles = [
            'Support for Education',
            'Casa da Mamé',
            'Special and Therapeutic Education Center (CEET)',
            'Health Support'
        ];

        $descriptions = [
            'We have supported 49 schools, equipping 220 classrooms and providing school supplies to 10,000 students in the Tombali region. We set up 5 libraries and a mobile library',
            'Casa da Mamé is a heart house that welcomes children whose mother died in childbirth. It allows them access to food, health care, education and love. It is a true home.',
            'CEET is a clinical center dedicated to the diagnosis, treatment and improvement of the quality of life of children with disabilities.',
            'We support the Catió Hospital and Health Centers in the Tombali region with medical support, equipment and hospital supplies and medicines.'
        ];
    }

@endphp

<div class="max-w-7xl mx-auto px-6 my-10 sm:my-16">
    @if (session('language') === 'pt')
        <h1>Principais projectos</h1>
    @elseif (session('language') === 'en')
        <h1>Main projects</h1>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 my-4">
        @for($i=0; $i<sizeof($titles); $i++)
            <a href="{{ $links[$i] }}" class="group block rounded border p-3 sm:p-4 transition hover:shadow-md">
                <img class="h-40 sm:h-52 w-full rounded-sm object-cover" src="/images/welcome/{{ $images[$i] }}" alt="{{ $titles[$i] }}">
                <h3 class="mt-3 mb-1 text-lg leading-tight group-hover:text-nrp-blue">{{ $titles[$i] }}</h3>
                <p class="my-0 text-base leading-snug text-gray-700">{{ $descriptions[$i] }}</p>
            </a>
        @endfor
    </div>

</div>
