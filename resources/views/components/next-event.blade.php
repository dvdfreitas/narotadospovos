@php
    use Illuminate\Support\Carbon;

    /**
     * Mostra o próximo evento marcado e desaparece no dia seguinte ao mesmo.
     *
     * As datas vivem aqui enquanto não houver tabela de eventos. Para passar
     * à base de dados basta trocar este array pela consulta: o resto do
     * componente só precisa de 'date' e 'title'.
     */
    $events = [
        ['date' => '2026-10-31', 'title' => 'Dia do Voluntário'],
    ];

    $today = Carbon::today();

    // Um evento continua à vista durante todo o seu dia: compara-se o dia,
    // não o instante.
    $next = collect($events)
        ->map(fn (array $event) => [...$event, 'date' => Carbon::parse($event['date'])->startOfDay()])
        ->filter(fn (array $event) => $event['date']->gte($today))
        ->sortBy('date')
        ->first();
@endphp

@if ($next)
    @php
        $days = (int) $today->diffInDays($next['date']);

        $countdown = match ($days) {
            0 => 'É hoje',
            1 => 'É amanhã',
            default => "Faltam {$days} dias",
        };
    @endphp

    {{-- No telemóvel fica numa só linha; a partir de sm cresce um pouco e junta a data ao título. --}}
    <div class="max-w-7xl m-auto px-4 my-4 sm:px-6 sm:my-6">
        <div class="flex items-center gap-3 rounded-lg border border-gray-200 border-l-4 border-l-nrp-blue bg-white p-3 shadow-sm sm:gap-4 sm:px-5 sm:py-3">

            <div class="flex w-11 shrink-0 flex-col items-center justify-center rounded-md bg-nrp-blue py-1 text-white sm:w-14 sm:py-1.5">
                <span class="text-lg font-bold leading-none sm:text-2xl">{{ $next['date']->format('d') }}</span>
                <span class="text-[10px] font-semibold uppercase leading-tight tracking-wider sm:text-xs">
                    {{ $next['date']->locale('pt')->translatedFormat('M') }}
                </span>
            </div>

            <div class="min-w-0 flex-1">
                <p class="my-0 text-[10px] font-bold uppercase leading-tight tracking-wider text-nrp-green sm:text-xs sm:tracking-widest">
                    Próximo evento
                </p>
                <div class="sm:flex sm:min-w-0 sm:items-baseline sm:gap-2">
                    <h2 class="my-0 truncate text-sm font-bold leading-snug text-gray-900 sm:text-lg">
                        {{ $next['title'] }}
                    </h2>
                    <p class="my-0 hidden shrink-0 text-sm text-gray-600 sm:block">
                        · {{ ucfirst($next['date']->locale('pt')->translatedFormat('l, j \d\e F')) }}
                    </p>
                </div>
            </div>

            <span class="shrink-0 whitespace-nowrap rounded-full bg-nrp-blue/10 px-2.5 py-1 text-xs font-bold text-nrp-blue sm:px-3 sm:text-sm">
                {{ $countdown }}
            </span>

        </div>
    </div>
@endif
