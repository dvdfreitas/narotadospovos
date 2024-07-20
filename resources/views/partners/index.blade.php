<x-appLayout>
    <div class="w-full flex flex-col space-y-28">
        <!-- Hero section  -->
        <div class="flex w-full h-[520px]">
            <img src="/images/default.jpg" class="object-cover object-center">
        </div>
        <div class="w-full max-w-7xl m-auto space-y-14">
            <!-- Desclaimer -->
            <div class="grid grid-flow-row gap-2 mx-6 lg:mx-0">
                <h1 class="font-black text-lg md:text-3xl uppercase">Parceiros</h1>
                <p>
                    Não estamos sozinhos, nesta busca por um mundo melhor, mais justo e inclusivo, onde o
                    ser humano e o meio ambiente são centro das atenções. Temos vários parceiros que colaboram
                    connosco, contribuindo de forma direta e direta no desenvolvimento da na missão.
                </p>
            </div>
            <!-- Partners List -->
            <div class="grid grid-flow-row gap-6 mx-6 transition-all duration-75 
            ease-in-out sm:grid-cols-2 md:grid-cols-3 lg:mx-0 lg:grid-cols-4">
                @foreach($partners as $partner)
                    <x-partner :partner="$partner" />
                @endforeach
            </div>
            <div class="mx-6 lg:mx-0">
                {{ $partners->links() }}
            </div>
        </div>
    </div>
</x-appLayout>