@props(['partner', 'icons'])

<a href="{{ $partner->website }}" class="flex justify-center items-center">
    <img src="/images/partners/{{ $partner->logo }}" class="w-full object-cover" alt="{{ $partner->name }}"/>
</a>
