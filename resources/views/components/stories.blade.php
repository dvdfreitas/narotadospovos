<div class="max-w-7xl m-auto my-16 px-6">

    <div class="flex items-end justify-between mb-8 border-b border-neutral-200 pb-2">
         @if (session('language') === 'pt')
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Últimas notícias</h1>
        @else
            <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">Latest news</h1>
        @endif
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($stories as $story)
            <x-story :story="$story" />
        @endforeach
    </div>
</div>
