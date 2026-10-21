@php($en = session('language') === 'en')

@if ($partners->isNotEmpty())
<div class="max-w-7xl mx-auto px-6 my-10 sm:my-16">

    <div class="flex flex-wrap items-end justify-between gap-x-6 gap-y-2 mb-6 sm:mb-8 border-b border-neutral-200 pb-2">
        <h1 class="text-2xl font-bold text-neutral-900 tracking-tight">{{ $en ? 'Partners' : 'Parceiros' }}</h1>

        <a href="{{ route('partners.index') }}"
           class="group inline-flex items-center gap-1 text-sm font-semibold text-neutral-700 hover:text-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-neutral-900">
            {{ $en ? 'All partners' : 'Todos os parceiros' }}
            <svg class="h-4 w-4 text-neutral-400 transition-transform group-hover:translate-x-0.5 group-hover:text-black motion-reduce:transition-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
        </a>
    </div>

    <blockquote class="my-6 border-l-2 border-nrp-green pl-4 text-lg italic leading-relaxed text-neutral-700 sm:text-xl">
        @if ($en)
            <span class="block">If you want to go fast, go alone</span>
            <span class="block">If you want to go far, go together.</span>
            <cite class="mt-2 block text-sm font-semibold not-italic text-neutral-500">African Proverb</cite>
        @else
            <span class="block">Se queres ir rápido, vai sozinho</span>
            <span class="block">Se queres ir longe, vai acompanhado.</span>
            <cite class="mt-2 block text-sm font-semibold not-italic text-neutral-500">Provérbio Africano</cite>
        @endif
    </blockquote>

    <p class="max-w-2xl text-neutral-600">
        @if ($en)
            What Na Rota dos Povos has achieved is only possible thanks to many volunteers and partners.
        @else
            O que a Na Rota dos Povos tem conseguido fazer só é possível graças a muitos voluntários e parceiros.
        @endif
        @if ($total > $partners->count())
            <span class="text-neutral-500">{{ $en ? 'Here are some of them — each visit shows others.' : 'Aqui estão alguns — a cada visita mostramos outros.' }}</span>
        @endif
    </p>

    <ul role="list" class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-x-6 gap-y-8 sm:gap-x-8 my-8 list-none p-0">
        @foreach ($partners as $partner)
            <li><x-partner :partner="$partner" /></li>
        @endforeach
    </ul>
</div>
@endif
