<x-appLayout>
    <div class="flex flex-col w-full space-y-28">
        <!-- Hero section  -->
        <div class="flex w-full h-[520px]">
            <img src="/images/default.jpg" class="object-cover object-center">
        </div>

        <!-- Features -->
        <div class="w-full max-w-7xl flex flex-col m-auto space-y-28">
            <!-- News Featured Section -->
            <section class="flex flex-col mx-6 space-y-8 md:mx-0">
                <!-- Topic line  -->
                <div class="flex flex-row justify-between items-center">
                    <span class="font-black text-lg text-black md:text-3xl uppercase">Em destaque</span>
                    <span class="w-7/12 h-0.5 md:w-10/12 bg-gray-500"></span>
                </div>
                <div class="flex flex-col gap-16 md:grid md:grid-cols-2">
                    <!-- Story Card -> Featured news -->
                    <x-story :story="$stories[0]" format="highlight" />

                    <!-- Story Card -> subnews -->
                    <div class="w-full flex flex-col space-y-8 m-0 p-0">
                        @foreach ($stories as $story)
                            <x-story :story="$story" format="minimal" />
                        @endforeach
                        <div>{{ $stories->links() }}</div>
                    </div>

                </div>
            </section>

            <!-- Volunteer's daylly section  -->
            <section class="flex flex-col mx-6 space-y-8 md:mx-0">
                <!-- Topic line  -->
                <div class="flex flex-row justify-between items-center">
                    <span class="font-black text-lg text-black md:text-3xl uppercase">Diário de Voluntariado</span>
                    <span class="w-6/12 h-0.5 md:w-8/12 bg-gray-500"></span>
                </div>
                <!-- Top of volunteers daylly -->
                <div class="flex flex-col space-y-8 md:flex-row md:space-x-4 md:space-y-0 overflow-hidden ">
                    @foreach($stories as $story)
                        <x-story :story="$story" format="highlight" />
                    @endforeach
                </div>
            </section>
        </div>
    </div>
</x-appLayout>