<hr/>

@php
    if (session('language') === 'pt') {
        $follow_us = 'Siga-nos';
    } elseif (session('language') === 'en') {
        $follow_us = 'Follow us';
    }


@endphp

<footer class="bg-white dark:bg-gray-900">
    <div class="mx-auto w-full max-w-screen-xl p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-between">
          <div class="mb-6 md:mb-0">
            <a href="/" class="flex items-center">
                <img src="/images/logo.png" class="h-8" alt="Logo da Na Rota dos Povos" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Na Rota dos Povos</span>
            </a>
          </div>

          <div class="grid grid-cols-2 gap-8 sm:gap-6 sm:grid-cols-3">
              <div>
            {{--
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Resources</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="https://flowbite.com/" class="hover:underline">Flowbite</a>
                      </li>
                      <li>
                          <a href="https://tailwindcss.com/" class="hover:underline">Tailwind CSS</a>
                      </li>
                  </ul>
              </div>
              <div>
                --}}
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">{{ $follow_us }}</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-2">
                          <a href="https://www.facebook.com/NaRotaDosPovos" class="hover:underline ">Facebook</a>
                      </li>
                      <li class="mb-2">
                          <a href="https://www.instagram.com/NaRotaDosPovos" class="hover:underline">Instagram</a>
                      </li>
                      {{--<li class="mb-2">
                        <a href="" class="hover:underline">YouTube</a>
                        </li>--}}
                    <li class="mb-2">
                        <a href="https://www.linkedin.com/company/narotadospovos" class="hover:underline">LinkedIn</a>
                    </li>
                  </ul>
              </div>
              {{--
              <div>
                  <h2 class="mb-6 text-sm font-semibold text-gray-900 uppercase dark:text-white">Legal</h2>
                  <ul class="text-gray-500 dark:text-gray-400 font-medium">
                      <li class="mb-4">
                          <a href="#" class="hover:underline">Privacy Policy</a>
                      </li>
                      <li>
                          <a href="#" class="hover:underline">Terms &amp; Conditions</a>
                      </li>
                  </ul>
              </div>
              --}}
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
      <div class="sm:flex sm:items-center sm:justify-between">
          <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="/" class="hover:underline">Na Rota dos Povos</a>. All Rights Reserved.
          </span>
          <div class="flex mt-4 sm:justify-center sm:mt-0 space-x-2">
            <a href="https://www.facebook.com/NaRotaDosPovos" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                <img src="/icons/facebook.svg" class="h-4" alt="Instagram icon">
                <span class="sr-only">Facebook page</span>
            </a>
            <a href="https://www.instagram.com/NaRotaDosPovos" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                <img src="/icons/instagram.svg" class="h-4" alt="Instagram icon">
                <span class="sr-only">Instagram page</span>
            </a>
            <a href="https://www.linkedin.com/company/narotadospovos" class="text-gray-500 hover:text-gray-900 dark:hover:text-white">
                <img src="/icons/linkedin.svg" class="h-4" alt="Instagram icon">
                <span class="sr-only">LinkedIn page</span>
            </a>
          </div>
      </div>
    </div>
</footer>
