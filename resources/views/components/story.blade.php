@props(['story', 'format' => 'default'])

<div class="leading-normal w-full flex flex-col font-black space-y-2">
    <a href="/stories/{{ $story->slug }}">
        <img src="/stories/{{ $story->image }}">
        <p class="font-bold">{{ $story->title }}</p>
        <p class="text-xs">{{ $story->date }}</p>
        <p class="leading-tight">{{ $story->summary }}</p>
        <p class="text-sm font-bold">Ler mais</p>
    </a>
</div>

{{--
@php
if ($story->image)
    $image = asset('images/'. $story->image);
else
    $image = asset('images/default.jpg');
@endphp

@if ($format == 'default')


@elseif($format == 'highlight')

<div {{$attributes ->merge(['class' => 'flex flex-col items-center space-y-4'])}}>

    <a><img src="{{ $image }}"></a>

    <div class="w-full flex flex-col font-black space-y-2">
        <div class="flex space-x-2">
            @foreach($story->categories as $category)
            <a href="/stories/categories/{{ $category->slug }}" class="inline-block font-medium text-sm text-center text-gray-400 px-2 py-3
            rounded-lg shadow-sm no-underline uppercase hover:shadow-lg hover:text-gray-600 transition-all ease-out">
                {{$category->name}}
            </a>
            @endforeach
        </div>
        <a href="/stories/{{ $story->slug }}" class="font-bold text-lg"> {{ $story->title }} </a>
        <p class="flex flex-row space-x-2 text-sm text-gray-500">
            <span class="mr-2"> {{ $story -> date}} </span>|<span> By: {{ $story -> user-> name}}</span>
        </p>
    </div>

</div>

@elseif ($format == 'minimal')

<div class="flex flex-row justify-center items-center space-x-2 pb-6 border-b-[0.5px] border-gray-500">
    <div class="w-9/12 flex flex-col space-y-2 font-black">
        <div class="flex space-x-2">
            @foreach($story->categories as $category)
            <a href="/stories/categories/{{ $category->slug }}" class="inline-block font-medium text-sm text-center text-gray-400 px-2 py-3
                rounded-lg shadow-sm no-underline uppercase hover:shadow-lg hover:text-gray-600 transition-all ease-out">
                {{$category->name}}
            </a>
            @endforeach
        </div>
        <a href="/stories/{{ $story->slug }}"> {{ $story->title }} </a>
        <p class="flex flex-row space-x-2 text-sm text-gray-500">
            <span class="mr-2">{{ $story->date }}</span>|<span>{{ $story->user->name }}</span>
        </p>
    </div>
    <a class="w-3/12"><img src="{{$image}}"></a>
</div>

@else

<div></div>

@endif --}}
