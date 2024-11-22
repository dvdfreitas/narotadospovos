<div class="max-w-4xl m-auto my-16">

    @if (session('language') === 'pt')
        <h1>Multimédia</h1>
    @elseif (session('language') === 'en')
        <h1>Multimedia</h1>
    @endif

    <div class="aspect-w-16 aspect-h-9 border-2 border-gray-400 m-auto w-full my-8">
        <iframe class="w-full m-auto" height="315" src="https://www.youtube.com/embed/QBPkIOXMbjs?si=WkHeY2g6HlNqNmfz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</div>
