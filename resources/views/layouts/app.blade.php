<!DOCTYPE html>
<html lang="pt-PT" class="lenis lenis-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEOTools: meta, OpenGraph, Twitter, JSON-LD --}}
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    {!! JsonLd::generate() !!}

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="alternate icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#7C3AED">

    {{-- RSS --}}
    <link rel="alternate" type="application/rss+xml" title="Blog 99web" href="{{ route('blog.feed') }}">

    {{-- Fonts — preconnect + display=swap --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Alfa+Slab+One&display=swap" rel="stylesheet">

    {{-- DNS prefetch para recursos externos --}}
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    {{-- Anti-flash: aplica tema guardado antes do CSS carregar --}}
    <script>
        (function(){try{var t=localStorage.getItem('theme');if(t==='light'||(!t&&window.matchMedia('(prefers-color-scheme: light)').matches)){document.documentElement.classList.add('light')}}catch(e){}})();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    {{-- Google Analytics (se configurado no admin) --}}
    @if(!empty($settings) && $settings->get('google_analytics_id'))
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $settings->get('google_analytics_id') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $settings->get('google_analytics_id') }}');
    </script>
    @endif
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
