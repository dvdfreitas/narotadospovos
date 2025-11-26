<x-guestLayout>
    @section('social_description', 'Campanha de Recolha de Bens Essenciais')
    @section('social_image', '/stories/2025/11/recolha2025.png')

    <x-margins-text>



        <h1>Dar Alimentos, Dar Sorrisos!</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">26 de novembro de 2025</p>

        <div class="mt-6 mb-8 flex flex-col items-center gap-4">

            @php
                $photos = [
                    '/stories/2025/11/face6.jpg',
                    '/stories/2025/11/face2.jpg',
                    '/stories/2025/11/face3.png',
                    '/stories/2025/11/face4.jpg',
                    '/stories/2025/11/face5.jpg',
                    '/stories/2025/11/face1.jpg',
                ];
            @endphp

            <div class="w-full max-w-5xl">
                <div class="flex justify-center gap-3">
                    @foreach ($photos as $src)
                        <figure
                            class="w-24 sm:w-28 md:w-32 rounded-xl border border-gray-200 bg-white shadow-sm overflow-hidden">
                            <img src="{{ $src }}" alt="Sorriso de uma criança"
                                class="w-full h-20 sm:h-24 md:h-28 object-cover">
                        </figure>
                    @endforeach
                </div>
            </div>

            <p class="text-[11px] text-gray-500 text-center uppercase tracking-[0.22em]">
                1 € = 1 sorriso por dia
            </p>
        </div>




        <p>Todos os dias, na Casa da Mamé, em Catió, no sul da Guiné-Bissau, dezenas de crianças encontram um lugar
            seguro onde podem crescer, aprender e sorrir. Mas para que isso continue a ser possível, precisam da nossa
            ajuda.</p>

        <p>A tua contribuição — seja através da doação de alimentos ou de um apoio financeiro — transforma-se
            diretamente em refeições, nutrição e bem-estar para as crianças que acompanhamos. <strong>1 € = 1 sorriso
                por dia</strong> não é apenas uma frase: é o impacto real que podemos criar juntos.</p>

        <h2 class="text-xl font-semibold mt-8 mb-4">O que estamos a recolher</h2>
        <div class="mt-4 rounded-2xl border border-amber-100 bg-amber-50/60 p-6">
            <p class="text-sm font-semibold uppercase tracking-wide text-amber-700 mb-3">
                Estamos a recolher:
            </p>

            @php
                $items = [
                    ['label' => 'Leite em pó', 'icon' => '🥛'],
                    ['label' => 'Papas lácteas', 'icon' => '🥣'],
                    ['label' => 'Massa', 'icon' => '🍝'],
                    ['label' => 'Arroz', 'icon' => '🍚'],
                    ['label' => 'Atum', 'icon' => '🐟'],
                    ['label' => 'Salsichas', 'icon' => '🌭'],
                    ['label' => 'Azeite', 'icon' => '🫒'],
                    ['label' => 'Óleo', 'icon' => '🛢️'],
                    ['label' => 'Leguminosas', 'icon' => '🫘'],
                    ['label' => 'Cereais', 'icon' => '🥣'],
                    ['label' => 'Bolachas', 'icon' => '🍪'],
                ];
            @endphp

            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-amber-900">
                @foreach ($items as $item)
                    <li class="flex items-center gap-3">
                        <span
                            class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-100 text-amber-700 text-xs shadow-sm">
                            {{ $item['icon'] }}
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </li>
                @endforeach
            </ul>

            <p class="mt-4 text-xs text-amber-800">
                São alimentos essenciais para garantir refeições completas e nutritivas ao longo do mês.
            </p>
        </div>




        <h2 class="text-xl font-semibold mt-8 mb-4">Como podes ajudar</h2>

        <h3 class="text-lg font-medium mt-4 mb-2">💛 Doação de alimentos</h3>

        <p>
            Podes entregar os bens nos nossos pontos de recolha, mas pedimos que
            <strong>marques sempre previamente por telefone</strong>:
        </p>

        <ul class="mt-3 space-y-4 text-sm text-gray-900">
            <li class="flex flex-col">
                <span class="font-medium">
                    📍 Rua Gonçalves Zarco, 264-4 – Santa Cruz do Bispo – Matosinhos
                </span>
                <span class="mt-1 flex flex-wrap items-center gap-3 text-gray-700">
                    <span class="flex items-center gap-1">
                        <span>📞</span> 932 412 050
                    </span>
                </span>
            </li>

            <li class="flex flex-col">
                <span class="font-medium">
                    📍 Rua da Portelinha, 483 – Fânzeres – Gondomar
                </span>
                <span class="mt-1 flex flex-wrap items-center gap-3 text-gray-700">
                    <span class="flex items-center gap-1">
                        <span>📞</span> 919 446 418
                    </span>
                </span>
            </li>
        </ul>

        <p class="mt-3 text-xs text-gray-600">
            Para garantir que alguém está disponível para receber os bens,
            <strong>é indispensável fazer contacto prévio</strong> através de um dos números indicados.
        </p>
        <h3 class="text-lg font-medium mt-6 mb-2">💛 Donativo financeiro</h3>
        <p>Mesmo um pequeno contributo tem um enorme impacto:</p>
        <ul class="list-none ml-0 my-3">
            <li><strong>MBWAY:</strong> 932 412 050</li>
            <li><strong>IBAN:</strong> PT50 0036 0407 9910 6015 0401 9</li>
        </ul>

        <p>Com <strong>25 €</strong>, conseguimos garantir um cabaz alimentar para <strong>uma criança durante um
                mês</strong>.</p>

        <h2 class="text-xl font-semibold mt-10 mb-4">Porque isto importa</h2>
        <p>A Casa da Mamé acolhe, educa e alimenta <strong>21 crianças</strong>, oferecendo-lhes acompanhamento diário,
            segurança e oportunidades.</p>
        <p>Em paralelo, o CEET presta apoio educativo, terapêutico e alimentar a <strong>20 crianças com
                deficiência</strong>. Para estas crianças e famílias, cada gesto de solidariedade é uma oportunidade de
            viver com dignidade.</p>

        <p class="mt-10 text-lg font-semibold">Junta-te a nós.<br>Dar alimentos é dar esperança. Dar sorrisos é
            transformar vidas.</p>
    </x-margins-text>
</x-guestLayout>
