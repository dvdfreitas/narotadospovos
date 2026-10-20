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

    <div class="max-w-7xl m-auto px-6 my-10">
        <div class="flex flex-col gap-5 rounded-xl border border-gray-200 border-l-4 border-l-nrp-blue bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:gap-6">

            <div class="flex w-20 shrink-0 flex-col items-center justify-center rounded-lg bg-nrp-blue py-3 text-white">
                <span class="text-3xl font-bold leading-none">{{ $next['date']->format('d') }}</span>
                <span class="mt-1 text-xs font-semibold uppercase tracking-widest">
                    {{ $next['date']->locale('pt')->translatedFormat('M') }}
                </span>
            </div>

            <div class="flex-1">
                <p class="mb-1 mt-0 text-xs font-bold uppercase tracking-widest text-nrp-green">
                    Próximo evento
                </p>
                <h2 class="mb-1 mt-0 text-xl font-bold text-gray-900">
                    {{ $next['title'] }}
                </h2>
                <p class="my-0 text-sm text-gray-600">
                    {{ ucfirst($next['date']->locale('pt')->translatedFormat('l, j \d\e F')) }}
                </p>
            </div>

            <span class="shrink-0 self-start rounded-full bg-nrp-blue/10 px-4 py-2 text-sm font-bold text-nrp-blue sm:self-auto">
                {{ $countdown }}
            </span>

        </div>
    </div>
@endif
