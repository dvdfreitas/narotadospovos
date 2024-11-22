@php
    $motto = '';
    if (session('language') === 'pt') {
        $motto = "A Educação é o Único Caminho";
    } elseif (session('language') === 'en') {
        $motto = "Education is the Only Way";
    }
@endphp


<div class="m-auto my-16 flex justify-center">
    <p class="text-7xl text-center self-center">{{ $motto }}</p>
</div>
