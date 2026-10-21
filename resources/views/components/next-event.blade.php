@php
    use App\Models\Event;
    use Illuminate\Support\Carbon;

    /**
     * Mostra o próximo evento e permite andar pelos seguintes com as setas.
     * Um evento sai da lista no dia seguinte ao seu último dia. Nada é
     * apagado da base de dados: só deixa de ser mostrado. Eventos
     * escondidos não aparecem.
     */
    $events = Event::visible()
        ->upcoming()
        ->with('dates')
        ->limit(10)
        ->get();

    $many = $events->count() > 1;
@endphp

@if ($events->isNotEmpty())
    {{-- No telemóvel fica numa só linha; a partir de sm cresce um pouco e junta a data ao título. --}}
    <div class="max-w-7xl m-auto px-4 my-4 sm:px-6 sm:my-6">
        <div x-data="{ i: 0, n: {{ $events->count() }} }"
             class="flex items-center gap-2 rounded-lg border border-gray-200 border-l-4 border-l-nrp-blue bg-white p-3 shadow-sm sm:gap-4 sm:px-5 sm:py-3">

            @foreach ($events as $event)
                @php
                    $next = $event->nextDate();
                    $cancelled = $event->isCancelled();
                    $days = (int) Carbon::today()->diffInDays($next, false);

                    $countdown = match (true) {
                        $cancelled => 'Cancelado',
                        $event->happensToday() => 'É hoje',
                        $days <= 0 => 'Terminou',
                        $days === 1 => 'É amanhã',
                        default => "Faltam {$days} dias",
                    };
                @endphp

                <div @if (! $loop->first) x-cloak @endif
                     x-show="i === {{ $loop->index }}"
                     class="flex min-w-0 flex-1 items-center gap-3 sm:gap-4">

                    <div @class([
                        'flex w-11 shrink-0 flex-col items-center justify-center rounded-md py-1 text-white sm:w-14 sm:py-1.5',
                        'bg-nrp-blue' => ! $cancelled,
                        'bg-gray-400' => $cancelled,
                    ])>
                        <span class="text-lg font-bold leading-none sm:text-2xl">{{ $next->format('d') }}</span>
                        <span class="text-[10px] font-semibold uppercase leading-tight tracking-wider sm:text-xs">
                            {{ $next->locale('pt')->translatedFormat('M') }}
                        </span>
                    </div>

                    <div class="min-w-0 flex-1">
                        <p class="my-0 truncate text-[10px] font-bold uppercase leading-tight tracking-wider text-nrp-green sm:text-xs sm:tracking-widest">
                            {{ $loop->first ? 'Próximo evento' : 'Evento seguinte' }}
                            @if ($many)
                                <span class="font-semibold text-gray-400">· {{ $loop->iteration }}/{{ $loop->count }}</span>
                            @endif
                        </p>
                        <div class="sm:flex sm:min-w-0 sm:items-baseline sm:gap-2">
                            <h2 class="my-0 truncate text-sm font-bold leading-snug text-gray-900 sm:text-lg">
                                {{ $event->name }}
                            </h2>
                            <p class="my-0 hidden shrink-0 text-sm text-gray-600 sm:block">
                                ·
                                @foreach ($event->dateLabels() as $label)
                                    <span @class(['line-through' => $label['cancelled']])>{{ $label['text'] }}</span>@unless ($loop->last){{ $loop->remaining === 1 ? ' e' : ',' }}@endunless
                                @endforeach
                            </p>
                        </div>
                        @if (filled($event->description))
                            <p class="my-0 truncate text-xs text-gray-500">{{ $event->description }}</p>
                        @endif
                        {{-- Com setas não há espaço para o selo no telemóvel: a contagem passa para baixo do título. --}}
                        @if ($many)
                            <p @class([
                                'my-0 text-xs font-semibold sm:hidden',
                                'text-nrp-blue' => ! $cancelled,
                                'text-red-700' => $cancelled,
                            ])>{{ $countdown }}</p>
                        @endif
                    </div>

                    <span @class([
                        'shrink-0 whitespace-nowrap rounded-full px-2.5 py-1 text-xs font-bold sm:px-3 sm:text-sm',
                        'bg-nrp-blue/10 text-nrp-blue' => ! $cancelled,
                        'bg-red-50 text-red-700' => $cancelled,
                        'hidden sm:inline-block' => $many,
                    ])>
                        {{ $countdown }}
                    </span>
                </div>
            @endforeach

            @if ($many)
                <div class="flex shrink-0 items-center">
                    <button type="button" @click="i--" :disabled="i === 0" aria-label="Evento anterior"
                            class="flex h-8 w-8 items-center justify-center rounded-full text-nrp-blue hover:bg-nrp-blue/10 disabled:cursor-default disabled:opacity-30 disabled:hover:bg-transparent">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button type="button" @click="i++" :disabled="i === n - 1" aria-label="Evento seguinte"
                            class="flex h-8 w-8 items-center justify-center rounded-full text-nrp-blue hover:bg-nrp-blue/10 disabled:cursor-default disabled:opacity-30 disabled:hover:bg-transparent">
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

        </div>
    </div>
@endif
