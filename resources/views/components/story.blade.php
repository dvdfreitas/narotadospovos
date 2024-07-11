@props(['story', 'format' => 'default'])

@if ($format == 'default')

    <div class=""></div>

@elseif($format == 'highlight')

    <div {{$attributes ->merge(['class' => 'flex flex-col items-center space-y-4'])}}>
        <a format="image"> <img src="/img/hero1.jpg" class=""></a>
        <div class="w-full flex flex-col font-black space-y-2">
            <a format="category">Environments</a>
            <a>{{ $story->title }}</a>
            <p class="flex flex-row space-x-2 text-sm text-gray-300">
                <span class="mr-2"> {{ $story -> date}} </span>|<span> By: {{ $story -> user-> name}}</span>
            </p>
        </div>
    </div>

@elseif ($format == 'minimal')

    <div class="flex flex-row justify-center items-center space-x-2 pb-6 border-b-[0.5px] border-gray-300">
        <div class="w-9/12 flex flex-col space-y-2 font-black">
            <a format="category"> Health Care </a>
            <a> {{ $story->title }} </a>
            <p class="flex flex-row space-x-2 text-sm text-gray-300">
                <span class="mr-2">{{ $story->date }}</span>|<span>{{ $story->user->name }}</span>
            </p>
        </div>
        <a format="image" class="w-3/12 bg-red-400"><img src="/img/hero1.jpg"></a>
    </div>

@else

    <div class=""></div>

@endif