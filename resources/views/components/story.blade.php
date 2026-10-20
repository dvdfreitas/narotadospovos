@props(['story', 'format' => 'default'])

@php
    $url = Str::startsWith($story->url, '/') ? $story->url : '/noticias/' . $story->url;
    $imageUrl = $story->image ? '/stories/' . $story->image : '/images/default.jpg';

    // 'compact' cabe duas por linha no telemóvel: sem resumo nem categoria,
    // que voltam a aparecer a partir de sm.
    $compact = $format === 'compact';
@endphp

<div class="group flex flex-col h-full bg-white border border-neutral-200 hover:border-neutral-400 hover:shadow-sm transition-all duration-300">

    <a href="{{ $url }}" class="flex flex-col h-full">

        <div class="{{ $compact ? 'p-2 sm:p-3' : 'p-3' }} pb-0 sm:pb-0">
            <div class="w-full aspect-[4/5] overflow-hidden rounded bg-neutral-100 relative">
                <img src="{{ $imageUrl }}"
                     alt="{{ $story->title }}"
                     class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out">
            </div>
        </div>

        <div class="{{ $compact ? 'p-2.5 sm:p-4' : 'p-4' }} flex flex-col flex-1">

            <div class="flex items-center gap-2 {{ $compact ? 'mb-1 sm:mb-2' : 'mb-2' }}">
                <span class="{{ $compact ? 'text-[10px] sm:text-xs' : 'text-xs' }} font-bold uppercase tracking-widest text-neutral-400">
                    {{ $story->date }}
                </span>
                @if($story->categories->isNotEmpty())
                   <span class="{{ $compact ? 'max-sm:hidden' : '' }} w-1 h-1 rounded-full bg-neutral-300"></span>
                   <span class="{{ $compact ? 'max-sm:hidden' : '' }} text-xs font-bold uppercase tracking-widest text-neutral-800">
                       {{ $story->categories->first()->name }}
                   </span>
                @endif
            </div>

            <h3 class="{{ $compact ? 'mt-1 mb-2 line-clamp-3 sm:mt-4 text-sm sm:line-clamp-none sm:text-lg' : 'text-lg mb-2' }} font-bold leading-tight text-neutral-900 group-hover:text-black">
                {{ $story->title }}
            </h3>

            <p class="{{ $compact ? 'max-sm:hidden' : '' }} text-neutral-600 text-sm leading-relaxed line-clamp-3 mb-3">
                {{ $story->summary }}
            </p>

            <div class="mt-auto {{ $compact ? 'pt-2 sm:pt-3' : 'pt-3' }} border-t border-neutral-100">
                <span class="{{ $compact ? 'text-xs sm:text-sm' : 'text-sm' }} font-semibold text-neutral-900 flex items-center gap-1 group-hover:gap-2 transition-all">
                    Ler mais
                    <svg class="w-3 h-3 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </span>
            </div>
        </div>
    </a>
</div>
