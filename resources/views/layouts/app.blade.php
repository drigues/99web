<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO --}}
    <title>@yield('title', config('app.name', '99web'))</title>
    <meta name="description" content="@yield('description', 'Agência digital especializada em soluções web modernas e eficientes.')">
    <meta name="keywords" content="@yield('keywords', 'desenvolvimento web, agência digital, sites, aplicações web')">
    <meta name="author" content="99web">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('og_title', config('app.name', '99web'))">
    <meta property="og:description" content="@yield('og_description', 'Agência digital especializada em soluções web modernas e eficientes.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.png'))">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:site_name" content="{{ config('app.name', '99web') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ url()->current() }}">
    <meta name="twitter:title" content="@yield('og_title', config('app.name', '99web'))">
    <meta name="twitter:description" content="@yield('og_description', 'Agência digital especializada em soluções web modernas e eficientes.')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.png'))">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts: Inter --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body
    class="antialiased bg-brand-bg text-brand-text font-sans"
    x-data
>
    {{-- Header --}}
    @include('partials.header')

    {{-- Conteúdo principal --}}
    <main id="main-content" role="main">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer role="contentinfo">
        @yield('footer')
    </footer>

    @stack('scripts')
</body>
</html>
