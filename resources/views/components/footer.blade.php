@php
    $lang = session('language');
    $follow_us = $lang === 'en' ? 'Follow us' : 'Siga-nos';
    $rights_reserved = $lang === 'en' ? 'All Rights Reserved.' : 'Todos os direitos reservados.';
@endphp

<footer class="bg-white border-t border-gray-100 dark:bg-gray-900 dark:border-gray-800 mt-auto">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-10 lg:py-12">

        <div class="md:flex md:justify-between md:items-start">

            <div class="mb-8 md:mb-0">
                <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="/images/novologo.png" class="h-14 w-auto" alt="Logo da Na Rota dos Povos" />
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:gap-6 sm:grid-cols-2">

                <div>
                    <h2 class="mb-6 text-xs font-bold text-gray-900 uppercase tracking-[0.2em] dark:text-white border-b border-gray-100 pb-2 inline-block">
                        {{ $follow_us }}
                    </h2>
                    <ul class="text-gray-600 dark:text-gray-400 font-medium space-y-3">
                        <li>
                            <a href="https://www.facebook.com/NaRotaDosPovos" class="hover:text-nrp-blue hover:underline transition-colors flex items-center group">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-2 group-hover:bg-nrp-blue transition-colors"></span>
                                Facebook
                            </a>
                        </li>
                        <li>
                            <a href="https://www.instagram.com/NaRotaDosPovos" class="hover:text-nrp-blue hover:underline transition-colors flex items-center group">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-2 group-hover:bg-nrp-blue transition-colors"></span>
                                Instagram
                            </a>
                        </li>
                        <li>
                            <a href="https://www.linkedin.com/company/narotadospovos" class="hover:text-nrp-blue hover:underline transition-colors flex items-center group">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300 mr-2 group-hover:bg-nrp-blue transition-colors"></span>
                                LinkedIn
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <hr class="my-6 border-gray-100 sm:mx-auto dark:border-gray-800 lg:my-8" />

        <div class="sm:flex sm:items-center sm:justify-between">
            <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © 2024 Na Rota dos Povos. All Rights Reserved.
            </span>


            <div class="flex mt-4 sm:justify-center sm:mt-0 space-x-5">
                <a href="https://www.facebook.com/NaRotaDosPovos" class="text-gray-400 hover:text-blue-600 dark:hover:text-white transform hover:scale-110 transition-all duration-300">
                    <img src="/icons/facebook.svg" class="h-5 w-5" alt="Facebook">
                    <span class="sr-only">Facebook page</span>
                </a>
                <a href="https://www.instagram.com/NaRotaDosPovos" class="text-gray-400 hover:text-pink-600 dark:hover:text-white transform hover:scale-110 transition-all duration-300">
                    <img src="/icons/instagram.svg" class="h-5 w-5" alt="Instagram">
                    <span class="sr-only">Instagram page</span>
                </a>
                <a href="https://www.linkedin.com/company/narotadospovos" class="text-gray-400 hover:text-blue-500 dark:hover:text-white transform hover:scale-110 transition-all duration-300">
                    <img src="/icons/linkedin.svg" class="h-5 w-5" alt="LinkedIn">
                    <span class="sr-only">LinkedIn page</span>
                </a>
            </div>
        </div>
    </div>
</footer>
