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
        '/education',
        '/casa-da-mame',
        '/ceet',
        '/health'
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

<div class="max-w-8xl m-auto my-16">
    @if (session('language') === 'pt')
        <h1>Principais projectos</h1>
    @elseif (session('language') === 'en')
        <h1>Main projects</h1>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 my-4">
        @for($i=0; $i<sizeof($titles); $i++)
            <div class="border p-4 rounded hover:shadow-md">
                <img class="h-56 w-full object-cover" src="/images/welcome/{{ $images[$i] }}" alt="{{ $titles[$i] }}">
                <h3>{{ $titles[$i] }}</h3>
                <p>{{ $descriptions[$i] }}</p>
            </div>
        @endfor
    </div>

</div>
