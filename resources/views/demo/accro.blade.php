<!DOCTYPE html>
<html lang="pt" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACCCRO — Associação Empresarial da Região Oeste</title>
    <meta name="description" content="Associação Empresarial da Região do Oeste. Consultoria, formação, networking e incentivos para o desenvolvimento dos negócios.">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-[#1A1A2E] antialiased">

{{-- ── Demo banner ──────────────────────────────────────────── --}}
<div class="bg-[#2D6AE0] text-white text-center text-xs py-2 px-4 relative z-50">
    Este é um projeto demonstrativo criado pela
    <a href="/" class="underline font-semibold hover:text-blue-200 transition-colors">99web</a>
</div>

{{-- ── Header ───────────────────────────────────────────────── --}}
<header class="bg-[#1d3e67] shadow-md sticky top-0 z-40" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <a href="#" class="flex items-center -my-1">
                <img src="{{ asset('images/accro/logo.jpg') }}"
                     alt="ACCCRO - Associação Empresarial"
                     class="h-20 w-auto"
                     width="217" height="106"
                     loading="eager">
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden lg:flex items-center gap-7">
                <a href="#inicio" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Início</a>
                <a href="#noticias" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Notícias & Eventos</a>
                <a href="#servicos" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Serviços</a>
                <a href="#acelerar2030" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Acelerar2030</a>
                <a href="#trilhos" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Trilhos</a>
                <a href="#contacto" class="text-sm font-medium text-white/80 hover:text-white transition-colors">Contacto</a>
            </nav>

            {{-- CTA --}}
            <a href="#associar" class="hidden lg:inline-flex bg-white hover:bg-gray-100 text-[#1d3e67] text-sm font-semibold rounded-lg px-5 py-2 transition-colors">
                Associar-me
            </a>

            {{-- Mobile hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-white" aria-label="Menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="lg:hidden bg-[#1a3558] border-t border-white/10 shadow-lg">
        <nav class="max-w-7xl mx-auto px-4 py-4 flex flex-col gap-1">
            <a @click="mobileOpen = false" href="#inicio" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Início</a>
            <a @click="mobileOpen = false" href="#noticias" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Notícias & Eventos</a>
            <a @click="mobileOpen = false" href="#servicos" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Serviços</a>
            <a @click="mobileOpen = false" href="#acelerar2030" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Acelerar2030</a>
            <a @click="mobileOpen = false" href="#trilhos" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Trilhos</a>
            <a @click="mobileOpen = false" href="#contacto" class="block px-3 py-2.5 rounded-lg text-sm font-medium text-white/80 hover:bg-white/10 hover:text-white transition-colors">Contacto</a>
            <div class="border-t border-white/10 mt-2 pt-3">
                <a href="#associar" @click="mobileOpen = false" class="block text-center bg-white hover:bg-gray-100 text-[#1d3e67] text-sm font-semibold rounded-lg px-5 py-2.5 transition-colors">
                    Associar-me
                </a>
            </div>
        </nav>
    </div>
</header>

{{-- ── Hero ─────────────────────────────────────────────────── --}}
<section id="inicio" class="relative min-h-[600px] lg:min-h-[700px] flex items-center overflow-hidden">
    {{-- Background Image --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/accro/hero-bg.jpg') }}"
             alt="Praça da Fruta, Caldas da Rainha"
             class="w-full h-full object-cover"
             width="1536" height="1024"
             loading="eager">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0F1B2D]/90 via-[#0F1B2D]/80 to-[#0F1B2D]/60"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full text-white">
        <div class="lg:grid lg:grid-cols-2 gap-12 items-center">

            {{-- Left column --}}
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                <a href="#acelerar2030" class="inline-flex items-center gap-2 bg-blue-500/20 text-blue-300 text-sm font-medium rounded-full px-4 py-1.5 hover:bg-blue-500/30 transition-colors cursor-pointer">
                    Acelerando 2030 &#9659;
                </a>
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mt-6">
                    Impulsionamos o tecido empresarial do Oeste
                </h1>
                <p class="text-lg text-gray-300 mt-6 leading-relaxed">
                    Há mais de 40 anos ao lado das empresas da Região Oeste. Consultoria, formação, networking e incentivos e programas de financiamento para o desenvolvimento dos negócios.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 mt-8">
                    <a href="#servicos" class="inline-flex items-center justify-center gap-2 bg-[#2D6AE0] hover:bg-[#1E50B8] text-white font-medium rounded-lg px-6 py-3 transition-colors">
                        Descubra os Nossos Serviços
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                    <a href="#associar" class="inline-flex items-center justify-center border border-white/30 text-white rounded-lg px-6 py-3 font-medium hover:bg-white/10 transition-colors">
                        Associar-me
                    </a>
                </div>
            </div>

            {{-- Right column — floating card --}}
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 mt-12 lg:mt-0">
                <div class="bg-[#1A2E4A] rounded-2xl p-6 border border-white/10 relative">
                    <div class="absolute -top-3 -right-3 w-6 h-6 bg-[#F5A623] rounded-full animate-pulse"></div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-lg">🚀</span>
                        <span class="text-sm font-semibold text-blue-300 bg-blue-500/20 rounded-full px-3 py-0.5">Acelerar2030</span>
                    </div>
                    <p class="text-gray-300 text-sm leading-relaxed">
                        Programa de aceleração para PMEs da Região Oeste. Candidaturas abertas para a nova edição — apoio à digitalização, internacionalização e inovação.
                    </p>
                    <div class="flex gap-6 mt-5 pt-4 border-t border-white/10">
                        <div>
                            <p class="text-2xl font-bold text-white">500+</p>
                            <p class="text-xs text-gray-400 mt-0.5">PMEs apoiadas</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-[#F5A623]">40+</p>
                            <p class="text-xs text-gray-400 mt-0.5">Mentores</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-white">21</p>
                            <p class="text-xs text-gray-400 mt-0.5">Municípios</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Stats bar ────────────────────────────────────────────── --}}
<section class="bg-white py-8 shadow-sm relative z-10">
    <div class="max-w-5xl mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-0">
            @php
            $stats = [
                ['value' => '500+', 'label' => 'Empresas Associadas'],
                ['value' => '21',   'label' => 'Municípios Parceiros'],
                ['value' => '120+', 'label' => 'Eventos por Ano'],
                ['value' => '8',    'label' => 'Programas Ativos'],
            ];
            @endphp
            @foreach($stats as $i => $stat)
                <div class="text-center {{ $i < 3 ? 'md:border-r md:border-gray-200' : '' }}">
                    <p class="text-3xl font-bold text-[#0F1B2D]">{{ $stat['value'] }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Notícias & Eventos ───────────────────────────────────── --}}
<section id="noticias" class="bg-[#F7F8FA] py-16 px-4">
    <div class="max-w-7xl mx-auto" x-data="{ tab: 'noticias' }">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-[#1A1A2E]" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">Notícias & Eventos</h2>
                <div class="flex gap-6 mt-4">
                    <button @click="tab = 'noticias'"
                            :class="tab === 'noticias' ? 'border-[#2D6AE0] text-[#2D6AE0]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="pb-2 border-b-2 text-sm font-medium transition-colors">
                        Notícias
                    </button>
                    <button @click="tab = 'eventos'"
                            :class="tab === 'eventos' ? 'border-[#2D6AE0] text-[#2D6AE0]' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="pb-2 border-b-2 text-sm font-medium transition-colors">
                        Eventos
                    </button>
                </div>
            </div>
            <a href="#" class="text-[#2D6AE0] text-sm font-medium hover:underline flex items-center gap-1">
                Ver Tudo
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>

        {{-- Notícias tab --}}
        <div x-show="tab === 'noticias'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="lg:grid lg:grid-cols-5 gap-8">

                {{-- Featured --}}
                <div class="col-span-2 mb-8 lg:mb-0">
                    <div class="bg-gradient-to-br from-[#1A2E4A] to-[#0F1B2D] rounded-xl aspect-video flex items-center justify-center">
                        <svg class="w-16 h-16 text-white/20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z"/></svg>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span>28 Fev 2026</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span class="text-[#2D6AE0] font-medium">Programa</span>
                        </div>
                        <h3 class="font-bold text-xl mt-2 text-[#1A1A2E] leading-snug">
                            ACCCRO lança nova fase do Programa Acelerar2030 para PMEs da Região Oeste
                        </h3>
                        <p class="text-gray-600 mt-2 text-sm line-clamp-3">
                            A nova fase do programa traz apoios reforçados para digitalização e internacionalização, com foco nas micro e pequenas empresas dos 21 municípios abrangidos.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1 text-[#2D6AE0] text-sm font-medium mt-3 hover:underline">
                            Ler mais
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>

                {{-- List --}}
                <div class="col-span-3">
                    @php
                    $noticias = [
                        ['title' => 'Novas medidas de apoio à digitalização das empresas', 'date' => '25 Fev 2026', 'cat' => 'Incentivos'],
                        ['title' => 'Workshop de Marketing Digital para Gestão Local', 'date' => '22 Fev 2026', 'cat' => 'Formação'],
                        ['title' => 'Protocolo com Câmara Municipal para apoio ao empreendedorismo', 'date' => '18 Fev 2026', 'cat' => 'Parcerias'],
                        ['title' => 'Balanço do Acelerar 2030: números para conhecer', 'date' => '14 Fev 2026', 'cat' => 'Programa'],
                    ];
                    @endphp
                    @foreach($noticias as $i => $noticia)
                        <a href="#" class="flex gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }} group">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-200 to-gray-300 rounded-lg flex-shrink-0 flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6V7.5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-[#1A1A2E] line-clamp-2 group-hover:text-[#2D6AE0] transition-colors">{{ $noticia['title'] }}</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                    <span>{{ $noticia['date'] }}</span>
                                    <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                    <span>{{ $noticia['cat'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>

        {{-- Eventos tab --}}
        <div x-show="tab === 'eventos'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="lg:grid lg:grid-cols-5 gap-8">
                <div class="col-span-2 mb-8 lg:mb-0">
                    <div class="bg-gradient-to-br from-[#F5A623]/20 to-[#E8443A]/20 rounded-xl aspect-video flex items-center justify-center">
                        <svg class="w-16 h-16 text-[#F5A623]/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                    </div>
                    <div class="mt-4">
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <span>15 Mar 2026</span>
                            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                            <span class="text-[#F5A623] font-medium">Conferência</span>
                        </div>
                        <h3 class="font-bold text-xl mt-2 text-[#1A1A2E] leading-snug">
                            Conferência Anual do Tecido Empresarial do Oeste 2026
                        </h3>
                        <p class="text-gray-600 mt-2 text-sm line-clamp-3">
                            A maior conferência de empresários da Região Oeste regressa com oradores internacionais e workshops práticos.
                        </p>
                        <a href="#" class="inline-flex items-center gap-1 text-[#2D6AE0] text-sm font-medium mt-3 hover:underline">
                            Saber mais
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                    </div>
                </div>
                <div class="col-span-3">
                    @php
                    $eventos = [
                        ['title' => 'Feira Regional de Emprego e Formação 2026', 'date' => '22 Mar 2026', 'cat' => 'Feira'],
                        ['title' => 'Workshop: Financiamento Europeu para PMEs', 'date' => '28 Mar 2026', 'cat' => 'Workshop'],
                        ['title' => 'Encontro de Networking — Setor Agroalimentar', 'date' => '5 Abr 2026', 'cat' => 'Networking'],
                        ['title' => 'Sessão de Esclarecimento: Novo Código do Trabalho', 'date' => '12 Abr 2026', 'cat' => 'Sessão'],
                    ];
                    @endphp
                    @foreach($eventos as $evento)
                        <a href="#" class="flex gap-4 py-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }} group">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-lg flex-shrink-0 flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#2D6AE0]/60" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <h4 class="font-semibold text-[#1A1A2E] line-clamp-2 group-hover:text-[#2D6AE0] transition-colors">{{ $evento['title'] }}</h4>
                                <div class="flex items-center gap-2 text-xs text-gray-500 mt-1">
                                    <span>{{ $evento['date'] }}</span>
                                    <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                    <span>{{ $evento['cat'] }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ── Serviços ─────────────────────────────────────────────── --}}
<section id="servicos" class="bg-white py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
            <h2 class="text-3xl font-bold text-[#1A1A2E]">Os Nossos Serviços</h2>
            <p class="text-gray-500 mt-3">Apoiamos as empresas da Região Oeste com uma vasta categoria de serviços</p>
        </div>

        @php
        $servicos = [
            ['icon' => '💼', 'title' => 'Consultoria Empresarial', 'desc' => 'Orientação estratégica e apoio à gestão e desenvolvimento dos negócios.'],
            ['icon' => '⚖️', 'title' => 'Apoio Jurídico', 'desc' => 'Consultoria legal para empresas em todas as áreas do direito empresarial e comercial.'],
            ['icon' => '🎓', 'title' => 'Formação Profissional', 'desc' => 'Programas de capacitação e formação para empresários e colaboradores.'],
            ['icon' => '🤝', 'title' => 'Networking', 'desc' => 'Eventos e encontros que conectam empresários e promovem parcerias.'],
            ['icon' => '🌍', 'title' => 'Internacionalização', 'desc' => 'Apoio na expansão para mercados internacionais e exportação.'],
            ['icon' => '💰', 'title' => 'Financiamento & Incentivos', 'desc' => 'Identificação e candidatura a programas de apoio e incentivos financeiros.'],
        ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-12">
            @foreach($servicos as $i => $servico)
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')"
                     class="opacity-0 bg-white border border-gray-200 rounded-xl p-6 hover:shadow-lg hover:border-blue-200 transition-all duration-300 group cursor-pointer"
                     style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                        {{ $servico['icon'] }}
                    </div>
                    <h3 class="font-semibold text-lg mt-4 text-[#1A1A2E]">{{ $servico['title'] }}</h3>
                    <p class="text-gray-600 text-sm mt-2 leading-relaxed">{{ $servico['desc'] }}</p>
                    <div class="flex items-center gap-1 text-[#2D6AE0] text-sm font-medium mt-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        Saber mais
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ── Acelerar2030 ─────────────────────────────────────────── --}}
<section id="acelerar2030" class="px-4 lg:px-20 my-8">
    <div class="bg-gradient-to-br from-[#1A3A2A] to-[#0D2618] text-white py-16 px-6 sm:px-10 lg:px-16 rounded-2xl border border-green-500/20">
        <div class="max-w-6xl mx-auto">
            <span class="inline-block bg-green-500/20 text-green-300 rounded-full px-4 py-1 text-sm font-semibold tracking-wide mb-6">
                #CONSTRUIR O FUTURO
            </span>

            <div class="lg:grid lg:grid-cols-2 gap-12 items-start">

                {{-- Left --}}
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                    <img src="{{ asset('images/accro/acelerar2030-logo.png') }}"
                         alt="Acelerar 2030 - Para um centro + digital"
                         class="h-16 w-auto mb-6"
                         width="320" height="80"
                         loading="lazy">

                    <h2 class="text-3xl lg:text-4xl font-bold">Acelerar2030</h2>

                    <p class="text-gray-300 text-base leading-relaxed mt-4">
                        Acelerar2030 é uma iniciativa que visa impulsionar o crescimento e a competitividade das empresas da região Centro de Portugal. Este projeto é liderado pelo CEC/CCIC - Conselho Empresarial do Centro/Câmara de Comércio e Indústria do Centro, em consórcio com 21 Associações Empresariais, com experiência em projetos de ligação ao tecido empresarial e com capilaridade regional de atuação junto do setor empresarial do comércio e serviços.
                    </p>

                    <p class="text-gray-300 text-base leading-relaxed mt-4">
                        A ACCCRO - Associação Empresarial das Caldas da Rainha e Oeste, orgulha-se de integrar este consórcio enquanto antena, dinamizando o projeto na região Oeste em parceria com a ACIRO - Associação Comercial, Industrial e Serviços da Região Oeste, uma das 8 aceleradoras da Região Centro.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-3 mt-8">
                        <a href="#associar" class="inline-flex items-center justify-center gap-2 bg-[#2D9B5E] hover:bg-[#248C50] text-white font-medium rounded-lg px-6 py-3 transition-colors">
                            Contactar a Aceleradora do Oeste
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </a>
                        <a href="https://acelerar2030.pt" target="_blank" rel="noopener" class="inline-flex items-center justify-center gap-2 border border-green-400/40 text-green-300 hover:bg-green-500/10 font-medium rounded-lg px-6 py-3 transition-colors">
                            Site Oficial Acelerar2030
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                    </div>
                </div>

                {{-- Right — stat cards --}}
                <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 mt-10 lg:mt-0">
                    <div class="grid grid-cols-2 gap-4">
                        @php
                        $acStats = [
                            ['value' => '21', 'label' => 'Municípios', 'color' => 'text-white'],
                            ['value' => '8', 'label' => 'Setores', 'color' => 'text-white'],
                            ['value' => '100+', 'label' => 'PMEs Apoiadas', 'color' => 'text-white'],
                            ['value' => '€2M', 'label' => 'Investimento', 'color' => 'text-[#34C66A]'],
                        ];
                        @endphp
                        @foreach($acStats as $st)
                            <div class="bg-[#1E4D35]/60 rounded-xl p-5 text-center border border-green-500/10 hover:border-green-500/25 transition-colors">
                                <p class="text-3xl font-bold {{ $st['color'] }}">{{ $st['value'] }}</p>
                                <p class="text-gray-400 text-sm mt-1">{{ $st['label'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ── Torne-se Associado ───────────────────────────────────── --}}
<section id="associar" class="bg-white py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="lg:grid lg:grid-cols-2 gap-16 items-start">

            {{-- Left --}}
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0 mb-10 lg:mb-0">
                <h2 class="text-3xl font-bold text-[#1A1A2E]">Torne-se Associado</h2>
                <p class="text-gray-600 mt-4 text-lg leading-relaxed">
                    Faça parte da maior rede empresarial da Região Oeste e aceda a benefícios exclusivos.
                </p>
                <ul class="mt-8 space-y-4">
                    @php
                    $beneficios = [
                        'Consultoria empresarial e apoio jurídico',
                        'Acesso a workshops e programas de formação',
                        'Networking com outros empresários',
                        'Acesso ao Programa Acelerar2030',
                        'Representação e defesa de interesses',
                        'Visibilidade no diretório de empresas',
                    ];
                    @endphp
                    @foreach($beneficios as $b)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-emerald-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span class="text-gray-700">{{ $b }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Right — form --}}
            <div x-data x-intersect.once="$el.classList.add('animate-fade-in-up')" class="opacity-0">
                <div class="bg-[#F7F8FA] rounded-2xl p-8 border border-gray-200">
                    <h3 class="font-bold text-xl text-[#1A1A2E]">Pedido de Associação</h3>
                    <p class="text-gray-500 text-sm mt-1">Preencha os dados que entraremos em contacto</p>

                    <form class="mt-6 space-y-4" onsubmit="return false;">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Nome da Empresa <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="Ex: Empresa Lda">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">NIF/NIPC <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="000 000 000">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Nome do Responsável <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="Nome completo">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Cargo <span class="text-red-500">*</span></label>
                                <input type="text" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="Ex: Gerente">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="email@empresa.pt">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Telefone <span class="text-red-500">*</span></label>
                                <input type="tel" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors" placeholder="+351 000 000 000">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Setor de Atividade</label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors text-gray-700">
                                    <option value="">Selecionar...</option>
                                    <option>Comércio</option>
                                    <option>Indústria</option>
                                    <option>Serviços</option>
                                    <option>Turismo</option>
                                    <option>Agricultura</option>
                                    <option>Tecnologia</option>
                                    <option>Outro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">N.º de Colaboradores</label>
                                <select class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors text-gray-700">
                                    <option value="">Selecionar...</option>
                                    <option>1–9</option>
                                    <option>10–49</option>
                                    <option>50–249</option>
                                    <option>250+</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Mensagem</label>
                            <textarea rows="3" class="w-full bg-white border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors resize-none" placeholder="Informação adicional (opcional)"></textarea>
                        </div>
                        <button type="button" class="w-full bg-[#E8443A] hover:bg-[#d13a31] text-white font-medium rounded-lg py-3 transition-colors flex items-center justify-center gap-2">
                            Enviar Pedido de Associação
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Newsletter ───────────────────────────────────────────── --}}
<section class="bg-[#F7F8FA] py-12 px-4">
    <div class="max-w-2xl mx-auto text-center" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
        <h2 class="text-2xl font-bold text-[#1A1A2E]">Fique a Par de Tudo</h2>
        <p class="text-gray-500 mt-2">Receba as últimas notícias, eventos e oportunidades da ACCCRO diretamente no seu email.</p>
        <form class="flex flex-col sm:flex-row gap-2 mt-6 max-w-md mx-auto" onsubmit="return false;">
            <input type="email" placeholder="O seu email" class="flex-1 bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#2D6AE0]/30 focus:border-[#2D6AE0] outline-none transition-colors">
            <button type="button" class="bg-[#E8443A] hover:bg-[#d13a31] text-white text-sm font-medium rounded-lg px-6 py-2.5 transition-colors whitespace-nowrap">
                Subscrever
            </button>
        </form>
    </div>
</section>

{{-- ── Onde Estamos ─────────────────────────────────────────── --}}
<section id="contacto" class="bg-white py-16 px-4">
    <div class="max-w-7xl mx-auto">
        <h2 class="text-3xl font-bold text-[#1A1A2E] text-center" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">Onde Estamos</h2>

        <div class="lg:grid lg:grid-cols-5 gap-8 mt-10">

            {{-- Map --}}
            <div class="col-span-3 mb-8 lg:mb-0">
                <div class="bg-gray-200 rounded-xl aspect-video overflow-hidden">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3068.5!2d-9.1397!3d39.4036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd18fd0c0e4b6f1f%3A0x0!2sCaldas+da+Rainha!5e0!3m2!1spt-PT!2spt!4v1"
                        width="100%" height="100%" style="border:0; min-height: 320px;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Mapa — ACCCRO, Caldas da Rainha">
                    </iframe>
                </div>
            </div>

            {{-- Contact info --}}
            <div class="col-span-2" x-data x-intersect.once="$el.classList.add('animate-fade-in-up')">
                <div class="space-y-5">
                    @php
                    $contactInfo = [
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>', 'label' => 'Morada', 'value' => 'Av. 1º de Maio, 9, 1º, Esq 2500-081 CALDAS DA RAINHA Portugal'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>', 'label' => 'Telefone', 'value' => '262 832 203 / 937 219 198'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>', 'label' => 'Email', 'value' => 'geral@accro.pt'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>', 'label' => 'Horário', 'value' => 'Segunda à Sexta das 9:30 às 13:00 e das 14:00 às 18:00 Sábados, Domingos e Feriados encerrado'],
                        ['icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0H21M3.375 14.25h.008v.008h-.008v-.008zm0 0V3.375c0-.621.504-1.125 1.125-1.125h6.998c.308 0 .603.122.82.34l3.782 3.783c.217.217.34.512.34.82V14.25M3.375 14.25H12m0 0v4.5"/>', 'label' => 'Estacionamento', 'value' => 'Praça 25 de Abril 1ª hora grátis - Aberto 24 horas'],
                    ];
                    @endphp
                    @foreach($contactInfo as $info)
                        <div class="flex gap-3">
                            <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-[#2D6AE0]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">{!! $info['icon'] !!}</svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-400 uppercase tracking-wide">{{ $info['label'] }}</p>
                                <p class="text-[#1A1A2E] text-sm mt-0.5">{{ $info['value'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Logos Parceiros ─────────────────────────────────────── --}}
<section class="bg-white py-12 border-t border-gray-100">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-sm text-gray-500 mb-8 font-medium tracking-wide uppercase">Programa financiado por</p>
        <div class="flex items-center justify-center">
            <img src="{{ asset('images/accro/emat-acelerar-logos.jpg') }}"
                 alt="Parceiros do Programa Acelerar2030 - CEC, ACIRO, ACCCRO, PRR, República Portuguesa, União Europeia"
                 class="max-w-full h-auto max-h-24 lg:max-h-28 object-contain"
                 loading="lazy">
        </div>
        <p class="text-xs text-gray-400 mt-6">Projeto financiado pelo PRR - Plano de Recuperação e Resiliência no âmbito da NextGenerationEU</p>
    </div>
</section>

{{-- ── Footer ───────────────────────────────────────────────── --}}
<footer class="bg-[#0F1B2D] text-white pt-16 pb-8 px-4">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Branding --}}
            <div>
                <div class="mb-4">
                    <img src="{{ asset('images/accro/logo.jpg') }}"
                         alt="ACCCRO"
                         class="h-12 w-auto brightness-200"
                         width="217" height="106"
                         loading="lazy">
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    Associação Empresarial da Região do Oeste. Apoiamos empresas desde 1984.
                </p>
                <div class="flex gap-3 mt-5">
                    @php $socials = ['Facebook', 'LinkedIn', 'Instagram', 'YouTube']; @endphp
                    @foreach($socials as $social)
                        <a href="#" class="w-9 h-9 bg-white/10 rounded-full flex items-center justify-center text-gray-400 hover:bg-[#2D6AE0] hover:text-white transition-colors" title="{{ $social }}">
                            @if($social === 'Facebook')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M9.101 23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085 1.848-5.978 5.858-5.978.401 0 1.09.05 1.592.149v3.326a10 10 0 00-1.13-.065c-1.602 0-2.222.607-2.222 2.185v1.963h3.192l-.548 3.667h-2.644v8.12C18.62 23.074 23 18.588 23 13.096 23 7.265 18.351 2.5 12.378 2.5S1.757 7.265 1.757 13.096c0 4.872 3.444 8.95 8.043 10.02.175.038.352.065.53.084l-.009.004.78.087z"/></svg>
                            @elseif($social === 'LinkedIn')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            @elseif($social === 'Instagram')
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Nav --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-400 mb-4">Navegação</h4>
                <ul class="space-y-2.5">
                    <li><a href="#inicio" class="text-sm text-gray-400 hover:text-white transition-colors">Início</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Sobre</a></li>
                    <li><a href="#servicos" class="text-sm text-gray-400 hover:text-white transition-colors">Serviços</a></li>
                    <li><a href="#acelerar2030" class="text-sm text-gray-400 hover:text-white transition-colors">Acelerar2030</a></li>
                </ul>
            </div>

            {{-- Programas --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-400 mb-4">Programas</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Consultoria</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Formação</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Internacionalização</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Apoios e Incentivos</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div>
                <h4 class="font-semibold text-sm uppercase tracking-wider text-gray-400 mb-4">Legal</h4>
                <ul class="space-y-2.5">
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Política de Privacidade</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Termos e Condições</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Livro de Reclamações</a></li>
                    <li><a href="#" class="text-sm text-gray-400 hover:text-white transition-colors">Centro de Arbitragem</a></li>
                </ul>
            </div>

        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-white/10 mt-12 pt-6 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p class="text-xs text-gray-500">
                &copy; 2026 ACCCRO — Associação Empresarial da Região Oeste. Todos os direitos reservados.
            </p>
            <p class="text-xs text-gray-500">
                Desenvolvido por <a href="/" class="text-[#2D6AE0] hover:text-blue-400 font-medium transition-colors">99web.pt</a>
            </p>
        </div>
    </div>
</footer>

{{-- ── Animations ────────────────────────────────────────────── --}}
<style>
    [x-cloak] { display: none !important; }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInUp .6s ease-out forwards;
    }
</style>

</body>
</html>
