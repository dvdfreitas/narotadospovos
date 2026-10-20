<div class="w-full mb-12">
    <div class="relative h-[440px] sm:h-[500px] xl:h-[580px] 2xl:h-[620px] overflow-hidden bg-gray-900">
        <div
            x-data="{
                visible: 0,
                paused: false,
                images: [
                    '/images/heroes/hero1.jpg',
                    '/images/heroes/hero2.jpg',
                    '/images/heroes/hero3.jpg',
                    '/images/heroes/hero4.jpg',
                    '/images/heroes/hero5.jpg',
                    '/images/heroes/hero6.jpg',
                    '/images/heroes/hero7.jpg',
                    '/images/heroes/hero8.jpg',
                ],
                timer: null,
                // Cada mudança manual recomeça a contagem, senão a passagem
                // automática pode vir logo a seguir e parece que saltou duas.
                go(index) {
                    this.visible = (index + this.images.length) % this.images.length
                    this.restart()
                },
                next() { this.go(this.visible + 1) },
                prev() { this.go(this.visible - 1) },
                restart() {
                    clearInterval(this.timer)
                    this.timer = setInterval(() => { if (! this.paused) this.visible = (this.visible + 1) % this.images.length }, 8000)
                },
            }"
            x-init="restart()"
            {{-- Só o rato pausa: no telemóvel um toque não tem 'leave' e o carrossel ficava parado. --}}
            @pointerenter="if ($event.pointerType === 'mouse') paused = true"
            @pointerleave="paused = false"
            class="w-full h-full"
        >
            {{-- Slides: todos empilhados, só muda a opacidade --}}
            <template x-for="(image, index) in images" :key="image">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                     :class="index === visible ? 'opacity-100' : 'opacity-0'"
                     :aria-hidden="index === visible ? 'false' : 'true'">
                    <img class="object-cover object-center w-full h-full"
                         :src="image"
                         :loading="index === 0 ? 'eager' : 'lazy'"
                         alt="Na Rota dos Povos no terreno">
                </div>
            </template>

            {{-- Véu em baixo: os botões brancos têm de se ler sobre fotografias claras --}}
            <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/50 to-transparent pointer-events-none"></div>

            {{-- Indicadores --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-2 z-30">
                <template x-for="(image, index) in images" :key="'dot-' + image">
                    <button type="button" @click="go(index)"
                            :class="index === visible ? 'w-8 bg-white' : 'w-2.5 bg-white/60 hover:bg-white/90'"
                            class="h-2.5 p-0 border-none rounded-full cursor-pointer outline-none
                                   transition-all duration-300 focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-black/30">
                        <span class="sr-only" x-text="'Imagem ' + (index + 1)"></span>
                    </button>
                </template>
            </div>

            {{-- Seta da direita --}}
            <button type="button" @click="next()"
                    class="group absolute top-1/2 -translate-y-1/2 z-30 right-0 px-5 lg:right-40 lg:px-0
                           flex items-center justify-center touch-manipulation focus:outline-none">
                <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-white/90 backdrop-blur-sm
                             shadow-md [@media(hover:hover)]:group-hover:bg-white [@media(hover:hover)]:group-hover:scale-110 group-active:scale-95 group-focus-visible:ring-4
                             group-focus-visible:ring-white/90 transition duration-300 ease-in-out">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="sr-only">Seguinte</span>
                </span>
            </button>

            {{-- Seta da esquerda --}}
            <button type="button" @click="prev()"
                    class="group absolute top-1/2 -translate-y-1/2 z-30 left-0 px-5 lg:left-40 lg:px-0
                           flex items-center justify-center touch-manipulation focus:outline-none">
                <span class="inline-flex items-center justify-center w-11 h-11 rounded-full bg-white/90 backdrop-blur-sm
                             shadow-md [@media(hover:hover)]:group-hover:bg-white [@media(hover:hover)]:group-hover:scale-110 group-active:scale-95 group-focus-visible:ring-4
                             group-focus-visible:ring-white/90 transition duration-300 ease-in-out">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span class="sr-only">Anterior</span>
                </span>
            </button>
        </div>
    </div>
</div>
