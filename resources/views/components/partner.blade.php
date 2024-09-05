@props(['partners', 'icons'])

@foreach($partners as $partner)
    <div class="flex flex-row w-full space-x-6 p-6 justify-center items-center rounded-lg shadow-md transition-all 
    duration-75 ease-in-out hover:shadow-lg md:flex-col md:space-x-0 md:space-y-6">
        <div class="flex-shrink-0 w-16 h-16 p-2 rounded-full shadow-inner bg-gray-500/10 md:w-24 md:h-24">
            <img 
                src="{{ asset('logos/' . $partner->logo) }}" 
                class="w-full h-full object-cover object-center rounded-full shadow-inner" 
                alt="Logotipo de {{ $partner->name }}"
            >
        </div>
        <div class="flex flex-col w-full space-y-5 justify-center items-center">
            <div class="flex flex-col justify-center items-center">
                <h4 class="font-bold text-base text-gray-600 uppercase">{{ $partner->name }}</h4>
                <p class="font-normal text-sm text-gray-600">Lorem ipsum dolor sit amet.</p>
            </div>
            <div class="flex flex-row w-full space-x-2 justify-center items-center">
                @foreach($icons as $socialNetwork => $icon)
                    @if(!empty($partner->$socialNetwork))
                        <a href="{{ $partner->$socialNetwork  }}" 
                        class="h-7 w-7 p-2 rounded-full bg-gray-500/10 shadow-sm hover:shadow-md hover:bg-gray-500/30"
                        target="_blank">
                            <img 
                                src="{{ $icon }}" 
                                class="h-full w-full object-cover" 
                                alt="Icone do {{ $icon }}"
                            >
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endforeach