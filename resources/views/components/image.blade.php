@props(['img'])
<img {{ $attributes->merge(['src' => '/img/$img'])}}>