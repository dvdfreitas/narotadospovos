<nav class="bg-white border-b border-gray-200 dark:bg-gray-900 dark:border-gray-800">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto px-4 py-3">

        <a href="/" class="flex items-center">
            <img src="/images/novologo.png" class="h-10 w-auto" alt="Logo Na Rota dos Povos" />
        </a>

        <button data-collapse-toggle="navbar-multi-level" type="button" class="inline-flex items-center p-2 text-gray-900 rounded-md md:hidden hover:bg-gray-50 focus:outline-none transition-colors dark:text-gray-400 dark:hover:bg-gray-800" aria-controls="navbar-multi-level" aria-expanded="false">
            <span class="sr-only">Menu</span>
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
            <ul class="flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-2 mt-4 md:mt-0 font-medium">

                <li class="w-full md:w-auto">
                    @php $isWhoActive = request()->routeIs(['about', 'board', 'tales', 'statutes', 'reports']); @endphp
                    <button id="whoNavbarLink" data-dropdown-toggle="whoDropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-4 text-xs tracking-[0.1em] transition-all duration-200
                        {{ $isWhoActive ? 'text-gray-900 border-b-2 border-nrp-green font-bold' : 'text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        {{ session('language') === 'en' ? 'WHO WE ARE' : 'QUEM SOMOS' }}
                        <svg class="w-3 h-3 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="whoDropdownNavbar" class="z-20 hidden bg-white border border-gray-200 shadow-xl rounded-sm w-48 dark:bg-gray-800 dark:border-gray-700">
                        <ul class="text-xs text-gray-900 dark:text-gray-200 uppercase tracking-wider">
                            <li><a href="{{ route('about') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ session('language') === 'en' ? 'About us' : 'Sobre nós' }}</a></li>
                            <li><a href="{{ route('board') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ session('language') === 'en' ? 'Board' : 'Órgãos sociais' }}</a></li>
                            <li><a href="{{ route('tales') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ session('language') === 'en' ? 'Histories' : 'Histórias' }}</a></li>
                            <li><a href="{{ route('statutes') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ session('language') === 'en' ? 'Statutes' : 'Estatutos' }}</a></li>
                            <li class="border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('reports') }}" class="block px-4 py-3 font-bold hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">{{ session('language') === 'en' ? 'Reports' : 'Relatórios' }}</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="w-full md:w-auto">
                    @php $isProjectActive = request()->routeIs('projects.*'); @endphp
                    <button id="projectNavbarLink" data-dropdown-toggle="projectDropdownNavbar"
                        class="flex items-center justify-between w-full py-2 px-4 text-xs tracking-[0.1em] transition-all duration-200
                        {{ $isProjectActive ? 'text-gray-900 border-b-2 border-nrp-green font-bold' : 'text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        {{ session('language') === 'en' ? 'PROJECTS' : 'PROJETOS' }}
                        <svg class="w-3 h-3 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div id="projectDropdownNavbar" class="z-20 hidden bg-white border border-gray-200 shadow-xl rounded-sm w-56 dark:bg-gray-800 dark:border-gray-700">
                        <ul class="text-xs text-gray-900 dark:text-gray-200 uppercase tracking-wider">
                            <li><a href="{{ route('projects.education') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all border-l-2 border-transparent hover:border-nrp-green">{{ session('language') === 'en' ? 'Education support' : 'Apoio à educação' }}</a></li>
                            <li><a href="{{ route('projects.mame') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all border-l-2 border-transparent hover:border-nrp-green">Casa da Mamé</a></li>
                            <li><a href="{{ route('projects.ceet') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all border-l-2 border-transparent hover:border-nrp-green">CEET</a></li>
                            <li><a href="{{ route('projects.health') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all border-l-2 border-transparent hover:border-nrp-green">{{ session('language') === 'en' ? 'Health support' : 'Apoio à saúde' }}</a></li>
                            <li><a href="{{ route('projects.academy') }}" class="block px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all border-l-2 border-transparent hover:border-nrp-green">{{ session('language') === 'en' ? 'Sports academy' : 'Academia desportiva' }}</a></li>
                        </ul>
                    </div>
                </li>

                <li class="w-full md:w-auto">
                    <a href="{{ route('help') }}"
                        class="block py-2 px-4 text-xs tracking-[0.1em] transition-all duration-200
                        {{ request()->routeIs('help') ? 'text-gray-900 border-b-2 border-nrp-green font-bold' : 'text-gray-900 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-gray-800' }}">
                        {{ session('language') === 'en' ? 'HOW TO HELP' : 'COMO AJUDAR' }}
                    </a>
                </li>

                <li class="flex items-center md:ml-4 pt-4 md:pt-0 border-t md:border-t-0 md:border-l border-gray-200 md:pl-4 dark:border-gray-700">
                    <x-language-switch/>
                </li>
            </ul>
        </div>
    </div>
</nav>
