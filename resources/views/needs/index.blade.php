<x-guestLayout>

    @section('social_description', 'Campanha de Recolha')
    @section('social_image', '/stories/2025/01/recolha.png')

    <x-margins-text>

        <img src="{{ asset('stories/2025/01/recolha.png') }}" alt="Recolha de bens" class="w-full h-64 object-cover rounded-lg">

        <h1>Recolha de Bens Essenciais</h1>

        <p class="my-4">A NRP está a organizar uma recolha de bens essenciais para enviar para Catió. Se puder, contribua com um dos produtos abaixo listados. A sua ajuda é muito importante para nós.</p>

        <h2>Necessidades prioritárias</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 my-6">
            @foreach ($essential as $need)
                <div class="border-4 border-nrp-green rounded-xl p-2 ">
                    <p class="text-center">{{ $need->product->name }}</p>
                </div>
            @endforeach
        </div>

        <h2>Necessidades essenciais</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 my-6">
            @foreach ($nice_to_have as $need)
                <div class="border-4 border-nrp-blue rounded-xl p-2 ">
                    <p class="text-center">{{ $need->product->name }}</p>
                </div>
            @endforeach
        </div>

        <h2>Não necessitamos</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 my-6">
            @foreach ($dont_want as $need)
                <div class="border-4 border-red-400 rounded-xl p-2 ">
                    <p class="text-center">{{ $need->product->name }}</p>
                </div>
            @endforeach
        </div>


        <h2 class="mt-16">Pontos de Entrega</h2>
            <div class="my-2">
                <div>
                    <p class="font-bold">Armazém: </p>
                    <p>Rua Gonçalves Zarco, 2644</p>
                    <p>Santa Cruz do Bispo (próximo do Ikea Matosinhos)</p>
                    <p>Tel: 932 412 050</p>
                </div>
                <div>
                    <p class="font-bold">Curtes: <p>
                    <p>Rua da Portelinha, nº 483<p>
                    <p>4510-638 Fânzeres – Gondomar</p>
                </div>
            </div>
    </x-margins-text>
</x-guestLayout>
