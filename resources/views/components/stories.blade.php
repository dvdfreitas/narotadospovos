<div class="max-w-7xl mx-auto px-6 my-10 sm:my-16">

    <div class="flex items-end justify-between mb-6 sm:mb-8 border-b border-neutral-200 pb-2">
         @if (session('language') === 'pt')
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Últimas notícias</h1>
        @else
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Latest news</h1>
        @endif

        <a href="{{ route('stories.index') }}"
           class="group inline-flex items-center gap-1 text-sm font-semibold text-neutral-700 hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-900">
            {{ session('language') === 'pt' ? 'Todas as notícias' : 'All news' }}
            <svg class="h-4 w-4 text-neutral-400 transition-transform group-hover:translate-x-0.5 group-hover:text-black motion-reduce:transition-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
        @foreach ($stories as $story)
            <x-story :story="$story" format="compact" />
        @endforeach
    </div>
</div>
