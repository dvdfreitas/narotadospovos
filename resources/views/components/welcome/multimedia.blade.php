<div class="max-w-4xl mx-auto px-6 my-10 sm:my-16">

    @if (session('language') === 'pt')
        <h1>Multimédia</h1>
    @elseif (session('language') === 'en')
        <h1>Multimedia</h1>
    @endif

    <div class="my-6 aspect-video w-full overflow-hidden rounded bg-gray-100 sm:my-8">
        <iframe class="h-full w-full" src="https://www.youtube.com/embed/QBPkIOXMbjs?si=WkHeY2g6HlNqNmfz" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
    </div>
</div>
