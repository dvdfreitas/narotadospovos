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
        route('help') . '#firquidja',
        route('help') . '#donativo',
        route('help'),
    ];

@endphp

<div class="max-w-4xl mx-auto px-6 my-10 sm:my-16">

    @if (session('language') === 'pt')
        <h1>Como ajudar</h1>
    @elseif (session('language') === 'en')
        <h1>How to help</h1>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 sm:gap-6 my-4">

        @for ($i=0; $i<sizeof($title); $i++)
            <a href="{{ $links[$i] }}" class="group block h-full rounded border border-l-4 border-l-nrp-green p-4 transition hover:shadow-md">
                <h2 class="mt-0 mb-1 text-xl group-hover:text-nrp-blue">{{ $title[$i] }}</h2>
                <p class="my-0 text-base leading-snug text-gray-700">{{ $description[$i] }}</p>
            </a>
        @endfor
    </div>

</div>
