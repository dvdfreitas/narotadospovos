<section class="max-w-xl mx-auto mb-16">

    <div class="relative overflow-hidden" id="nrp-carousel">

        {{-- Slides --}}
        <div id="nrp-track" class="flex" style="transition: transform 0.7s ease-in-out;">
            <img src="/images/campanhas/2026/img1.jpg" class="w-full flex-shrink-0" alt="Na Rota dos Povos" />
            <img src="/images/campanhas/2026/img2.jpg" class="w-full flex-shrink-0" alt="Na Rota dos Povos" />
            <img src="/images/campanhas/2026/img3.jpg" class="w-full flex-shrink-0" alt="Na Rota dos Povos" />
            <img src="/images/campanhas/2026/img4.jpg" class="w-full flex-shrink-0" alt="Na Rota dos Povos" />
        </div>

        {{-- Seta esquerda --}}
        <button type="button" onclick="nrpCarousel.prev()" aria-label="Anterior"
            class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Seta direita --}}
        <button type="button" onclick="nrpCarousel.next()" aria-label="Seguinte"
            class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/60 text-white rounded-full p-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Indicadores --}}
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2" id="nrp-dots"></div>

    </div>

</section>

<script>
    var nrpCarousel = (function () {
        var total   = 4;
        var current = 0;
        var track   = document.getElementById('nrp-track');
        var dotsEl  = document.getElementById('nrp-dots');
        var timer;

        // Criar pontos
        for (var i = 0; i < total; i++) {
            var dot = document.createElement('button');
            dot.setAttribute('data-index', i);
            dot.style.cssText = 'width:8px;height:8px;border-radius:9999px;border:none;cursor:pointer;';
            dot.addEventListener('click', (function(idx){ return function(){ go(idx); resetTimer(); }; })(i));
            dotsEl.appendChild(dot);
        }

        function updateDots() {
            dotsEl.querySelectorAll('button').forEach(function (d) {
                var idx = parseInt(d.getAttribute('data-index'));
                d.style.backgroundColor = idx === current ? '#ffffff' : 'rgba(255,255,255,0.4)';
            });
        }

        function go(index) {
            current = (index + total) % total;
            track.style.transform = 'translateX(-' + (current * 100) + '%)';
            updateDots();
        }

        function resetTimer() {
            clearInterval(timer);
            timer = setInterval(function () { go(current + 1); }, 4000);
        }

        updateDots();
        resetTimer();

        return {
            next: function () { go(current + 1); resetTimer(); },
            prev: function () { go(current - 1); resetTimer(); }
        };
    })();
</script>
