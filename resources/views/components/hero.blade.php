<div class="w-full mb-12">
    <div class="relative h-[383px] sm:h-[433px] xl:h-[497px] 2xl:h-[520px] overflow-hidden">
        <div x-data="{ visible: 0, images: ['/images/heroes/hero1.jpg', '/images/heroes/hero1.jpg', '/images/heroes/hero2.jpg', '/images/heroes/hero3.jpg' , '/images/heroes/hero4.jpg', '/images/heroes/hero5.jpg', '/images/heroes/hero6.jpg', '/images/heroes/hero7.jpg', '/images/heroes/hero8.jpg']}" x-init="setInterval(()=> { visible++; visible = visible % 9 }, 8000);">
            {{-- Slides images --}}
            <template x-for="(image, index) in images">
                <div class="absolute w-full h-full">
                    <img class="object-cover object-center w-full h-full" :src="image" x-show="index == visible" />
                </div>
            </template>

            {{-- Slides indicators --}}
            <div class="absolute inline-block space-x-2 gap-3 bottom-8 left-1/2 -translate-x-1/2">
                <template x-for="(image, index) in images">
                    <button @click="visible = index" class="w-4 h-4 p-0 border-none rounded-full cursor-pointer outline-none bg-white/80
                    shadow-sm shadow-gray-600 hover:bg-white active:ring-4 ring-white/70"></button>
                </template>
            </div>

            {{-- Right navigation button --}}
            <button @click="visible++; if (visible == images.length) visible = 0;" class="absolute flex
            items-center justify-center h-auto top-1/2 -translate-y-1/2 z-30 right-0 px-5 lg:right-40 lg:px-0
            pointer-events-none group focus:outline-none">
                <span class="next-button enabled-button inline-flex items-center justify-center w-10 h-10 rounded-full bg-white
                    shadow-sm shadow-gray-400 hover:shadow-lg group-hover:bg-white/70 group-focus:ring-4
                    group-focus:ring-white/90 group-focus:outline-none transition duration-300 ease-in-out">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>

            {{-- Left navigation button --}}
            <button @click="visible--; if (visible == -1) visible = 4;" class="absolute flex items-center
            justify-center h-auto top-1/2 -translate-y-1/2 z-30 left-0 px-5 lg:left-40 lg:px-0
            pointer-events-none group focus:outline-none">
                <span class="prev-button  enabled-button inline-flex items-center justify-center w-10 h-10 rounded-full
                bg-white shadow-sm shadow-gray-400 hover:shadow-lg group-hover:bg-white/70 group-focus:ring-4
                group-focus:ring-white/90 group-focus:outline-none transition duration-300 ease-in-out">
                    <svg class="w-6 h-6 text-gray-500 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
        </div>
    </div>
</div>
