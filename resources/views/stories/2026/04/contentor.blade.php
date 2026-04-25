<x-guestLayout>
    @section('social_description', 'Campanha de Recolha de Bens para Catió — Faz a diferença com a tua doação!')
    @section('social_image', '/stories/2026/04/contentor.jpeg')

    <x-margins-text>

        <h1>Faz a diferença com a tua doação!</h1>

        <img src="/stories/2026/04/contentor.jpeg" alt="Campanha de Recolha de Bens para Catió" class="mt-6 w-full rounded-xl">

        <p class="mt-6">A Na Rota dos Povos está a organizar uma recolha de bens essenciais para enviar num contentor para Catió, na Guiné-Bissau. Com a tua ajuda, queremos garantir refeições completas e nutritivas para as <strong>21 crianças órfãs</strong> acolhidas na Casa da Mamé e para as <strong>20 crianças com deficiência</strong> acompanhadas no Centro de Educação Especial e Terapêutica (CEET).</p>

        <h2 class="text-xl font-semibold mt-8 mb-4">Bens alimentares</h2>
        <div class="rounded-2xl border border-amber-100 bg-amber-50/60 p-6">
            @php
                $alimentos = [
                    ['label' => 'Leite lactentes (tipos 1 e 2)', 'icon' => '🥛'],
                    ['label' => 'Leite Nido', 'icon' => '🥛'],
                    ['label' => 'Papas lácteas', 'icon' => '🥣'],
                    ['label' => 'Massa', 'icon' => '🍝'],
                    ['label' => 'Cereais', 'icon' => '🥣'],
                    ['label' => 'Arroz', 'icon' => '🍚'],
                    ['label' => 'Bolachas tipo Maria ou torrada', 'icon' => '🍪'],
                    ['label' => 'Enlatados (salsichas de aves, atum, sardinha, fruta)', 'icon' => '🐟'],
                    ['label' => 'Óleo', 'icon' => '🛢️'],
                    ['label' => 'Azeite', 'icon' => '🫒'],
                    ['label' => 'Leguminosas (secas ou enlatadas)', 'icon' => '🫘'],
                ];
            @endphp
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-amber-900">
                @foreach ($alimentos as $item)
                    <li class="flex items-center gap-3">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-amber-100 text-amber-700 text-xs shadow-sm">
                            {{ $item['icon'] }}
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <h2 class="text-xl font-semibold mt-8 mb-4">Produtos de higiene</h2>
        <div class="rounded-2xl border border-blue-100 bg-blue-50/60 p-6">
            @php
                $higiene = [
                    ['label' => 'Pasta e escova de dentes para crianças', 'icon' => '🪥'],
                    ['label' => 'Creme hidratante', 'icon' => '🧴'],
                    ['label' => 'Detergente (em pó, lixívia e sabão em barra)', 'icon' => '🧼'],
                    ['label' => 'Produtos de banho', 'icon' => '🛁'],
                ];
            @endphp
            <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-blue-900">
                @foreach ($higiene as $item)
                    <li class="flex items-center gap-3">
                        <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-blue-100 text-blue-700 text-xs shadow-sm">
                            {{ $item['icon'] }}
                        </span>
                        <span>{{ $item['label'] }}</span>
                    </li>
                @endforeach
            </ul>
        </div>

        <h2 class="text-xl font-semibold mt-8 mb-4">Pontos de recolha</h2>
        <ul class="space-y-4 text-sm text-gray-900">
            <li class="flex flex-col">
                <span class="font-medium">📍 Na Rota dos Povos — Rua Gonçalves Zarco, 2644, 4455-821 Santa Cruz do Bispo – Matosinhos</span>
            </li>
            <li class="flex flex-col">
                <span class="font-medium">📍 Leça da Palmeira — Ana Lúcia Cabeleireira, Rua Francisco Sá Carneiro, 322, 4450-676 Leça da Palmeira</span>
            </li>
            <li class="flex flex-col">
                <span class="font-medium">📍 Gondomar / Curtes — Rua da Portelinha, 483 – Fânzeres</span>
            </li>
        </ul>
        <p class="mt-3 text-xs text-gray-600">
            Para garantir que alguém está disponível para receber os bens, <strong>é indispensável fazer contacto prévio</strong>.
        </p>

        <h2 class="text-xl font-semibold mt-8 mb-4">Donativo financeiro</h2>
        <ul class="list-none ml-0 my-3">
            <li><strong>MBWAY:</strong> 932 412 050</li>
            <li><strong>IBAN:</strong> PT50 0036 0407 9910 6015 0401 9</li>
        </ul>

        <p class="mt-10 text-lg font-semibold">Cada gesto de solidariedade é esperança para estas crianças de Catió.</p>

    </x-margins-text>
</x-guestLayout>
