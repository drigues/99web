<!DOCTYPE html>
<html lang="pt-PT" class="lenis lenis-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', '99web — Websites Profissionais em Portugal')</title>
    <meta name="description" content="@yield('meta_description', 'Criamos websites modernos, sistemas corporativos e presença digital premium para empresas portuguesas.')">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', '99web')">
    <meta property="og:description" content="@yield('meta_description')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:type" content="website">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#7C3AED">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Instrument+Serif&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-[var(--black)] text-[var(--white)] antialiased overflow-x-hidden">

    @include('partials.cursor')
    @include('partials.loader')

    <div data-barba="wrapper">
        @include('partials.header-v2')

        <main data-barba="container" data-barba-namespace="@yield('namespace', 'home')">
            @yield('content')
        </main>

        @include('partials.footer-v2')
    </div>

    <x-modal-comecar />
    @stack('scripts')
</body>
</html>
