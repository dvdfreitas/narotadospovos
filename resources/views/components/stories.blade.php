<div class="max-w-8xl m-auto my-16">

    <div class="flex">
        @if (session('language') === 'pt')
            <h1>Últimas notícias</h1>
        @elseif (session('language') === 'en')
            <h1>Latest news</h1>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8 my-8">
        @foreach ($stories as $story)
            <x-story :story="$story" />
        @endforeach
    </div>
</div>
