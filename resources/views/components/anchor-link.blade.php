@props(['format' => 'default'])

@if($format == 'category')
    <a href="$link" {{ $attributes -> merge(['class' => 'text-sm text-[#0083b3] uppercase'])}}>
        <strong class="">{{ $slot }}</strong>
    </a>
@elseif($format == 'image')
    <a href="#" {{ $attributes -> merge(['class' => '']) }}> {{ $slot }} </a>
@else
    <a href="$link" {{ $attributes -> merge(['class' => 'text-base text-black md:text-xl'])}}>{{ $slot }}</a>
@endif