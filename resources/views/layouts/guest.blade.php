
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/png" sizes="160x161" href="{{ asset('images/logo.png') }}">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <meta property="og:title" content="@yield('social_description')">
        <meta property="og:image" content="@yield('social_image')">

        <!-- Retirar -->
        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />


        <!-- Natal -->
        {{--<script src="/js/snow.js"></script>--}}

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        {{-- Cada página pode empurrar as suas meta tags para aqui com @push('meta') --}}
        @stack('meta')

    </head>

    <body class="font-sans text-gray-900 antialiased px-1 md:px-0">
        <x-menu/>

        <main>
            {{ $slot }}
        </main>

        <x-footer/>

        <!-- Retirar -->
        <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

        @livewireScripts
    </body>
</html>
