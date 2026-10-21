@props(['partner', 'showName' => false])

{{--
    Logótipos sem moldura, com espaço comum e proporções originais.
    Leva ao site do parceiro quando existe; sem site, não é um link.
--}}
@php($tag = $partner->website ? 'a' : 'div')

<{{ $tag }}
    @if ($partner->website) href="{{ $partner->website }}" target="_blank" rel="noopener" @endif
    title="{{ $partner->name }}"
    {{ $attributes->class([
        'group flex flex-col items-center gap-3 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-nrp-blue',
    ]) }}>
    <span class="flex h-28 w-full items-center justify-center sm:h-32">
        @if ($partner->logoUrl())
            <img src="{{ $partner->logoUrl() }}" alt="{{ $partner->name }}" loading="lazy" class="max-h-24 max-w-full object-contain sm:max-h-28">
        @else
            <span class="text-center text-xs font-medium text-gray-500">{{ $partner->name }}</span>
        @endif
    </span>
    @if ($showName)
        <span class="text-center text-sm leading-tight text-gray-700 group-hover:text-gray-900">{{ $partner->name }}</span>
    @endif
</{{ $tag }}>
