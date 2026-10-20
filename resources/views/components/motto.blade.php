@php
    $motto = '';
    if (session('language') === 'pt') {
        $motto = "A Educação é o Único Caminho";
    } elseif (session('language') === 'en') {
        $motto = "Education is the Only Way";
    }
@endphp


{{--
    Os enfeites vêm do logótipo: as cores da marca e o caminho que atravessa
    o globo. Por cima, um mosaico de quadrados que sobe e desce; por baixo, o
    caminho em pontos, que avança devagar — "o único caminho". Só decoração:
    aria-hidden, e quieto para quem pediu menos movimento.
--}}
<div class="m-auto my-10 flex flex-col items-center px-6 sm:my-16">
    <div class="mb-6 flex items-end gap-1.5 sm:mb-8 sm:gap-2" aria-hidden="true">
        <span class="h-2 w-2 bg-nrp-blue/30 sm:h-2.5 sm:w-2.5"></span>
        <span class="h-3 w-3 bg-nrp-blue/60 sm:h-4 sm:w-4"></span>
        <span class="h-4 w-4 bg-nrp-blue sm:h-5 sm:w-5"></span>
        <span class="h-5 w-5 rotate-12 bg-[#006c94] sm:h-7 sm:w-7"></span>
        <span class="h-4 w-4 bg-nrp-green sm:h-5 sm:w-5"></span>
        <span class="h-3 w-3 bg-nrp-green/60 sm:h-4 sm:w-4"></span>
        <span class="h-2 w-2 bg-nrp-green/30 sm:h-2.5 sm:w-2.5"></span>
    </div>

    <p class="text-4xl font-bold tracking-tight leading-tight text-center text-balance self-center sm:text-6xl lg:text-7xl">{{ $motto }}</p>

    <svg class="mt-6 w-full max-w-xs sm:mt-8 sm:max-w-md" viewBox="0 0 400 60" fill="none" aria-hidden="true">
        <defs>
            <linearGradient id="motto-route" x1="0" y1="0" x2="400" y2="0" gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#0083b3" />
                <stop offset="1" stop-color="#91be4a" />
            </linearGradient>
        </defs>
        <circle cx="10" cy="44" r="6" fill="#0083b3" />
        <path d="M24 40 C 110 4, 190 64, 290 26 S 360 12, 378 20"
              stroke="url(#motto-route)" stroke-width="4" stroke-linecap="round"
              stroke-dasharray="0 12" class="motion-safe:animate-route" />
        <rect x="380" y="12" width="14" height="14" fill="#91be4a" transform="rotate(12 387 19)" />
    </svg>
</div>
