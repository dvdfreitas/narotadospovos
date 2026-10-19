@php
    $lang = session('language');
    $follow_us = $lang === 'en' ? 'Follow us' : 'Siga-nos';
    $rights_reserved = $lang === 'en' ? 'All rights reserved.' : 'Todos os direitos reservados.';
    $home_label = $lang === 'en' ? 'Na Rota dos Povos — home' : 'Na Rota dos Povos — página inicial';
    $social_links = [
        ['name' => 'Facebook', 'url' => 'https://www.facebook.com/NaRotaDosPovos', 'icon' => 'facebook'],
        ['name' => 'Instagram', 'url' => 'https://www.instagram.com/NaRotaDosPovos', 'icon' => 'instagram'],
        ['name' => 'LinkedIn', 'url' => 'https://www.linkedin.com/company/narotadospovos', 'icon' => 'linkedin'],
    ];
@endphp

<footer class="mt-auto border-t border-gray-100 bg-white dark:border-gray-800 dark:bg-gray-900">
    <div class="mx-auto flex w-full max-w-screen-xl flex-col gap-8 px-4 py-8 sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8">
        <div class="space-y-4">
            <a href="{{ route('welcome') }}" aria-label="{{ $home_label }}" class="inline-flex rounded focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-nrp-blue">
                <img src="/images/novologo.png" class="h-12 w-auto" alt="Na Rota dos Povos" />
            </a>
            <small class="block text-xs leading-relaxed text-gray-500 dark:text-gray-400">
                © {{ now()->year }} Na Rota dos Povos.
                <span class="block sm:inline">{{ $rights_reserved }}</span>
            </small>
        </div>

        <nav aria-labelledby="footer-social-heading">
            <h2 id="footer-social-heading" class="m-0 text-xs font-semibold uppercase tracking-widest text-gray-500 dark:text-gray-400 md:text-right">
                {{ $follow_us }}
            </h2>
            <ul class="mt-3 flex flex-wrap gap-x-5 gap-y-1">
                @foreach ($social_links as $social)
                    <li>
                        <a href="{{ $social['url'] }}" class="inline-flex min-h-11 items-center gap-2 rounded text-sm font-medium text-gray-600 transition-colors hover:text-nrp-blue focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-nrp-blue dark:text-gray-300 dark:hover:text-white">
                            <img src="/icons/{{ $social['icon'] }}.svg" class="h-4 w-4 shrink-0" alt="" aria-hidden="true" />
                            <span>{{ $social['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</footer>
