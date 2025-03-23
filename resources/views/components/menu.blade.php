<nav class="bg-white border-gray-200 dark:bg-gray-900 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
      <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
          <img src="/images/logo.png" class="h-8" alt="Logo da Na Rota dos Povos" />
          <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Na Rota dos Povos</span>
      </a>
      <button data-collapse-toggle="navbar-multi-level" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-multi-level" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
      <div class="hidden w-full md:block md:w-auto" id="navbar-multi-level">
        <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
            {{--<li>
                <a href="{{ route('needs.index') }}" class=" text-nrp-green  font-bold block py-2 px-3  rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-900 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">{{ __('Collection of essential goods') }}</a>
              </li>--}}
            <li>
                <button id="whoNavbarLink" data-dropdown-toggle="whoDropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-900 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('Who we are') }}
                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
              <!-- Dropdown menu -->
              <div id="whoDropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                  <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                    <li>
                      <a href="{{ route('about') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        @if (session('language') === 'en')
                            About us
                        @else
                            Sobre nós
                        @endif
                    </a>
                    </li>

                    <li>
                        <a href="{{ route('board') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            @if (session('language') === 'en')
                                Board
                            @else
                                Órgãos sociais
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tales') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            @if (session('language') === 'en')
                                Histories
                            @else
                                Histórias
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('statutes') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                            @if (session('language') === 'en')
                                Statutes
                            @else
                                Estatutos
                            @endif
                        </a>
                    </li>
                  </ul>
                  <div class="py-1">
                    <a href="{{ route('reports') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                        @if (session('language') === 'en')
                            Reports
                        @else
                            Relatórios
                        @endif
                    </a>
                  </div>

                </div>
          </li>

          <!-- Dropdown -->

          <li>
            <button id="projectNavbarLink" data-dropdown-toggle="projectDropdownNavbar" class="flex items-center justify-between w-full py-2 px-3 text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-900 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('Projects') }}
                <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>
            <!-- Dropdown menu -->
            <div id="projectDropdownNavbar" class="z-10 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownLargeButton">
                  <li>
                    <a href="{{ route('projects.education') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        @if (session('language') === 'en')
                            Education support
                        @else
                            Apoio à educação
                        @endif
                    </a>
                  </li>
                  <li>
                    <a href="{{ route('projects.mame') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Casa da Mamé</a>
                  </li>
                  <li>
                      <a href="{{ route('projects.ceet') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">CEET</a>
                  </li>
                  <li>
                    <a href="{{ route('projects.health') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        @if (session('language') === 'en')
                            Health support
                        @else
                            Apoio à saúde
                        @endif
                    </a>
                </li>
                <li>
                    <a href="{{ route('projects.academy') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        @if (session('language') === 'en')
                            Sports academy
                        @else
                            Academia desportiva
                        @endif
                    </a>
                </li>
                </ul>

            </div>
        </li>


          <li>
            <a href="{{ route('help') }}" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-green-900 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">{{ __('How to help') }}</a>
          </li>


            <x-language-switch/>
        </ul>
      </div>
    </div>
  </nav>
