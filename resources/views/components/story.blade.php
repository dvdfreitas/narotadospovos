@props(['story', 'format' => 'default'])
@if ($format == 'minimal')
    <div></div>
@elseif ($format == 'highlight')
    <div class="flex flex-row justify-center items-center space-x-2 pb-6 border-b-[0.5px] border-gray-300">
        <div class="w-full flex flex-col space-y-2 font-black">
            <strong class="text-sm text-[#0083b3] uppercase">{{ $story->title }}</strong>
            <h3 class="text-base text-black md:text-xl">{{ $story->summary }}</h3>
            <p class="flex flex-row space-x-2 text-sm text-gray-300">
                <span class="mr-2">{{ $story->date }}</span>|<span>{{ $story->user->name }}</span>
            </p>
        </div>
        <img src="/img/hero1.jpg" class="w-3/12">
    </div>
@else 
    <div class="flex flex-row justify-center items-center space-x-2">
        <div class="w-full flex flex-col space-y-2 font-black">
            <strong class="text-sm text-[#0083b3] uppercase">{{ $story->title }}</strong>
            <h3 class="text-base text-black md:text-xl">{{ $story->summary }}</h3>
            <p class="flex flex-row space-x-2 text-sm text-gray-300">
                <span class="mr-2">{{ $story->date }}</span>|<span>{{ $story->user->name }}</span>
            </p>
        </div>
        <img src="{{ $story->image }}" class="w-3/12">
    </div>
@endif
