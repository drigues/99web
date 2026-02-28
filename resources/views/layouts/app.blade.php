<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- SEO (gerido pelo SeoService) --}}
    <x-seo-head />

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#7C3AED">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Google Fonts: DM Sans + Instrument Serif --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Instrument+Serif&display=swap" rel="stylesheet">

    {{-- Vite assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Analytics --}}
    <x-analytics />

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
    @include('partials.footer')

    {{-- Modal global "Começar Agora" --}}
    <x-modal-comecar />

    @stack('scripts')
</body>
</html>
