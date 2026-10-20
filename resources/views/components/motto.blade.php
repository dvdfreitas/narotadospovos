@php
    $motto = '';
    if (session('language') === 'pt') {
        $motto = "A Educação é o Único Caminho";
    } elseif (session('language') === 'en') {
        $motto = "Education is the Only Way";
    }
@endphp


<div class="m-auto my-10 flex justify-center px-6 sm:my-16">
    <p class="text-4xl leading-tight text-center text-balance self-center sm:text-6xl lg:text-7xl">{{ $motto }}</p>
</div>
