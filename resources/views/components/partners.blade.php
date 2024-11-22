@php
    $quote = '';
    $description = '';

    if (session('language') === 'pt') {
        $quote = "Se queres ir rápido, vai sozinho<br>Se queres ir longe, vai acompanhado.<p class='text-sm font-bold'>Provérbio Africano</p>";
        $description = 'O que a "Na Rota dos Povos" tem conseguido fazer, só é possível graças a colaboração de muitos voluntários e de muitos parceiros.';
    } elseif (session('language') === 'en') {
        $quote = "If you want to go fast, go alone<br>If you want to go far, go together.<p class='text-sm font-bold'>African Proverb</p>";
        $description = 'What "Na Rota dos Povos" has been able to do is only possible thanks to the collaboration of many volunteers and many partners.';
    }

@endphp

<div class="max-w-8xl m-auto my-16">

    <h1>Parceiros</h1>
    <div class="max-w-sm space-y-0 leading-tight font-extralight my-4">
        <div>{!! $quote !!}</div>
    </div>
    <p>{{ $description }}</p>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 xl:grid-cols-12 gap-4 my-6">
        @foreach ($partners as $partner)
            <x-partner :partner="$partner"/>
        @endforeach
    </div>
</div>
