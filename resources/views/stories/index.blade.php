<x-guestLayout>
    @section('social_description', 'Notícias — Na Rota dos Povos')

    <div class="bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14">

            <header class="mb-8 border-b border-stone-200 pb-7 sm:mb-10">
                <h1 class="m-0 text-3xl font-semibold tracking-tight text-slate-900 sm:text-4xl">Notícias</h1>
                <p class="mb-0 mt-3 max-w-2xl text-left text-base font-normal leading-relaxed text-slate-600">
                    O que temos feito, as campanhas em curso e as histórias de quem caminha connosco.
                </p>
            </header>

            {{-- TOPO: a mais recente em grande e, ao lado, a que está em destaque. Só na primeira página e sem filtro. --}}
            @if ($latest && $stories->onFirstPage())
                <section aria-label="Notícias em destaque" class="grid gap-6 lg:grid-cols-3">
                    <article class="lg:col-span-2">
                        {{-- Quase todas as imagens são cartazes ao alto: lado a lado, o cartaz cabe sem ser cortado ao meio. --}}
                        <a href="{{ $latest->link() }}" class="group flex h-full flex-col overflow-hidden rounded-xl md:flex-row border border-stone-200 bg-white transition-shadow hover:shadow-lg hover:shadow-stone-200/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94] motion-reduce:transition-none">
                            <div class="aspect-[4/3] shrink-0 overflow-hidden bg-stone-100 md:aspect-[4/5] md:w-[45%]">
                                <img src="{{ $latest->imageUrl() }}" alt="" loading="eager"
                                    class="h-full w-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-[1.03] motion-reduce:transition-none">
                            </div>
                            <div class="flex flex-1 flex-col p-6 sm:p-8">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
                                    <span class="rounded-full bg-[#006c94] px-2.5 py-1 font-semibold uppercase tracking-wider text-white">Mais recente</span>
                                    <time datetime="{{ $latest->date }}" class="font-medium uppercase tracking-wider text-slate-500">{{ $latest->displayDate() }}</time>
                                    @if ($latest->categories->isNotEmpty())
                                        <span class="font-semibold uppercase tracking-wider text-slate-700">{{ $latest->categories->first()->name }}</span>
                                    @endif
                                </div>
                                <h2 class="mb-0 mt-4 text-2xl font-semibold leading-tight tracking-tight text-slate-900 group-hover:text-[#006c94] sm:text-3xl">{{ $latest->title }}</h2>
                                @if ($latest->subtitle)
                                    <p class="mb-0 mt-2 text-left text-lg font-normal text-slate-700">{{ $latest->subtitle }}</p>
                                @endif
                                <p class="mb-0 mt-3 line-clamp-3 text-left text-base font-normal leading-relaxed text-slate-600">{{ $latest->summary }}</p>
                                <span class="mt-auto inline-flex items-center gap-1.5 pt-6 text-sm font-semibold text-[#006c94]">
                                    Ler notícia
                                    <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transition-none" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                </span>
                            </div>
                        </a>
                    </article>

                    @if ($featured)
                        <article>
                            <a href="{{ $featured->link() }}" class="group flex h-full flex-col overflow-hidden rounded-xl border border-stone-200 bg-white transition-shadow hover:shadow-lg hover:shadow-stone-200/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94] motion-reduce:transition-none">
                                <div class="aspect-[4/3] overflow-hidden bg-stone-100">
                                    <img src="{{ $featured->imageUrl() }}" alt="" loading="eager"
                                        class="h-full w-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-[1.03] motion-reduce:transition-none">
                                </div>
                                <div class="flex flex-1 flex-col p-6">
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs">
                                        @if ($featured->is_featured)
                                            <span class="rounded-full bg-amber-100 px-2.5 py-1 font-semibold uppercase tracking-wider text-amber-900">Em destaque</span>
                                        @endif
                                        <time datetime="{{ $featured->date }}" class="font-medium uppercase tracking-wider text-slate-500">{{ $featured->displayDate() }}</time>
                                    </div>
                                    <h2 class="mb-0 mt-4 text-xl font-semibold leading-tight tracking-tight text-slate-900 group-hover:text-[#006c94]">{{ $featured->title }}</h2>
                                    <p class="mb-0 mt-3 line-clamp-4 text-left text-sm font-normal leading-relaxed text-slate-600">{{ $featured->summary }}</p>
                                    <span class="mt-auto inline-flex items-center gap-1.5 pt-6 text-sm font-semibold text-[#006c94]">
                                        Ler notícia
                                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5 motion-reduce:transition-none" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M4 10h12m-5-5 5 5-5 5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                    </span>
                                </div>
                            </a>
                        </article>
                    @endif
                </section>
            @endif

            {{-- TODAS AS OUTRAS --}}
            @if ($years->isEmpty())
                <p class="text-slate-500">Ainda não há histórias publicadas.</p>
            @else
                <section id="todas" aria-labelledby="all-news-title" @class(['scroll-mt-6', 'mt-14' => $latest && $stories->onFirstPage()])>
                    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-stone-200 pb-4">
                        <h2 id="all-news-title" class="m-0 text-2xl font-semibold tracking-tight text-slate-900">
                            {{ $year ? "Notícias de {$year}" : 'Todas as notícias' }}
                        </h2>

                        @if ($years->count() > 1)
                            <nav aria-label="Filtrar por ano" class="flex flex-wrap gap-2">
                                @foreach ([null, ...$years] as $option)
                                    <a href="{{ route('stories.index', array_filter(['ano' => $option])) }}#todas"
                                        @if ($option === $year) aria-current="page" @endif
                                        @class([
                                            'inline-flex min-h-9 items-center rounded-full px-4 text-sm font-medium ring-1 ring-inset transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#006c94]',
                                            'bg-[#006c94] text-white ring-[#006c94]' => $option === $year,
                                            'bg-white text-slate-700 ring-stone-300 hover:ring-[#006c94] hover:text-[#006c94]' => $option !== $year,
                                        ])>{{ $option ?? 'Todas' }}</a>
                                @endforeach
                            </nav>
                        @endif
                    </div>

                    @if ($stories->isEmpty())
                        <p class="mt-6 text-slate-500">Não há mais notícias para mostrar.</p>
                    @else
                        {{-- compact: duas por linha no telemóvel; a partir de sm é igual ao normal. --}}
                        <div class="mt-6 grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
                            @foreach ($stories as $story)
                                <x-story :story="$story" format="compact" />
                            @endforeach
                        </div>
                    @endif

                    @if ($stories->hasPages())
                        <div class="mt-10">
                            {{ $stories->fragment('todas')->links() }}
                        </div>
                    @endif
                </section>
            @endif
        </div>
    </div>
</x-guestLayout>
