@php

    $title = [];
    $description = [];

    if (session('language') === 'pt') {
        $title = [
            'Ser Firquidja',
            'Donativo',
            'Voluntariado'
        ];
    } elseif (session('language') === 'en') {
        $title = [
            'Be a Firquidja',
            'Donate',
            'Volunteer'
        ];
    }

    if (session('language') === 'pt') {
        $description = [
            'Apoie as nossas crianças tornando-se num firquidja da Casa da Mamé!',
            'Faça um donativo e seja a mudança que quer ver no mundo!',
            'Tem algumas horas livres que gostava de dedicar à "Na Rota dos Povos"?'
        ];
    } elseif (session('language') === 'en') {
        $description = [
            'Support our children by becoming a firquidja of Casa da Mamé!',
            'Make a donation and be the change you want to see in the world!',
            'Do you have some free time that you would like to dedicate to "Na Rota dos Povos"?'
        ];
    }

    $links = [
        '/firquidja',
        '/donativo',
        '/voluntariado'
    ];

@endphp

<div class="max-w-4xl m-auto my-16">

    @if (session('language') === 'pt')
        <h1>Como ajudar</h1>
    @elseif (session('language') === 'en')
        <h1>How to help</h1>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-12">

        @for ($i=0; $i<sizeof($title); $i++)
            <a href="{{ $links[$i] }}" class="cursor-pointer">
                <div>
                    <h2>{{ $title[$i] }}</h2>
                    <p class="leading-tight">{{ $description[$i] }}</p>
                </div>
            </a>
        @endfor
    </div>

</div>
