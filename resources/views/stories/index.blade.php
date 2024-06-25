<x-guestLayout>
    <div class="flex flex-col w-full space-y-28">
        <div class="flex w-full h-[520px]">
            <img src="/img/hero1.jpg" class="object-cover object-center">
        </div>
        <div class="w-full max-w-7xl flex flex-col m-auto space-y-28">
            <!-- Featured Section -->
            <x-featured-section>
                <!-- Featured Story header Card  -->
                <x-featured-story>
                    <x-featured-story-title>Em Destaque</x-featured-story-title>
                    <x-featured-story-line class="w-7/12 md:w-10/12"></x-featured-story-line>
                </x-featured-story>
                <!-- Featured Story Detail Card -->
                <div class="flex flex-col gap-16 md:grid md:grid-cols-2">
                    <!-- Featured Detail -->
                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>

                    <!-- subnews -->
                    <div class="w-full flex flex-col space-y-8 m-0 p-0">
                        <x-featured-story-card class="flex-row justify-center space-x-2 pb-2 border-b-[0.5px] border-gray-300">
                            <x-featured-story-detail>
                                <x-category>Health</x-category>
                                <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                                <x-featured-footer>
                                    <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                    <x-featured-footer-detail>By John Cristen</x-featured-footer-detail>
                                </x-featured-footer>
                            </x-featured-story-detail>
                            <img src="/img/hero1.jpg" class="w-3/12">
                        </x-featured-story-card>

                        <x-featured-story-card class="flex-row justify-center space-x-2 pb-2 border-b-[0.5px] border-gray-300">
                            <x-featured-story-detail>
                                <x-category>Foster House</x-category>
                                <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                                <x-featured-footer>
                                    <x-featured-footer-detail>23 June 2024</x-featured-footer-detail> |
                                    <x-featured-footer-detail>By Catherin Blues</x-featured-footer-detail>
                                </x-featured-footer>
                            </x-featured-story-detail>
                            <img src="/img/hero1.jpg" class="w-3/12">
                        </x-featured-story-card>

                        <x-featured-story-card class="flex-row justify-center space-x-2">
                            <x-featured-story-detail>
                                <x-category>Social Support</x-category>
                                <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                                <x-featured-footer>
                                    <x-featured-footer-detail>22 May 2024</x-featured-footer-detail> |
                                    <x-featured-footer-detail>By Brodus Ederson</x-featured-footer-detail>
                                </x-featured-footer>
                            </x-featured-story-detail>
                            <img src="/img/hero1.jpg" class="w-3/12">
                        </x-featured-story-card>
                    </div>
                </div>
            </x-featured-section>

            <!-- Volunteer's daylly section  -->
            <x-featured-section>
                <!-- Featured Story Card  -->
                <x-featured-story>
                    <x-featured-story-title>Diário de Voluntariado</x-featured-story-title>
                    <x-featured-story-line class="w-6/12 md:w-8/12"></x-featured-story-line>
                </x-featured-story>
                <!-- Top of volunteers daylly -->
                <div class="flex flex-col space-y-8 md:flex-row md:space-x-4 md:space-y-0 overflow-hidden ">
                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>

                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>

                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>

                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>

                    <x-featured-story-card class="flex-col space-y-4">
                        <a href="#" class="">
                            <img src="/img/hero1.jpg">
                        </a>
                        <x-featured-story-detail>
                            <x-category>Education</x-category>
                            <x-link href="#">Lorem ipsum dolor sit, amet consectetur adipisicing elit.</x-link>
                            <x-featured-footer>
                                <x-featured-footer-detail>24 June 2024</x-featured-footer-detail> |
                                <x-featured-footer-detail>By Jorge Mango</x-featured-footer-detail>
                            </x-featured-footer>
                        </x-featured-story-detail>
                    </x-featured-story-card>
                </div>
            </x-featured-section>
        </div>
    </div>
</x-guestLayout>