<div class="max-w-7xl mx-auto px-6 my-10 sm:my-16">

    <div class="flex items-end justify-between mb-6 sm:mb-8 border-b border-neutral-200 pb-2">
         @if (session('language') === 'pt')
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Últimas notícias</h1>
        @else
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Latest news</h1>
        @endif
    </div>

    <div class="grid grid-cols-2 gap-3 sm:gap-6 lg:grid-cols-4">
        @foreach ($stories as $story)
            <x-story :story="$story" format="compact" />
        @endforeach
    </div>
</div>
