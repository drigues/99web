<header x-data="{ scrolled: false, mobileOpen: false, light: document.documentElement.classList.contains('light') }"
        @scroll.window="scrolled = (window.scrollY > 50)"
        :class="scrolled ? 'bg-[var(--black)]/80 backdrop-blur-xl border-b border-[var(--border-subtle)]' : 'bg-transparent'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-500">
    <nav class="max-w-7xl mx-auto px-6 lg:px-8 h-20 flex items-center justify-between">

        {{-- Logo --}}
        <a href="/" class="text-2xl" data-magnetic>
            <span class="font-display"><span class="text-[var(--accent)]">99</span>web</span>
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden lg:flex items-center gap-10">
            <a href="#servicos" class="text-sm text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">Serviços</a>
            <a href="#projetos" class="text-sm text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">Projetos</a>
            <a href="#pacotes" class="text-sm text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">Pacotes</a>
            <a href="/blog" class="text-sm text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">Blog</a>
            <a href="#faq" class="text-sm text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">FAQ</a>
        </div>

        {{-- CTA + Theme Toggle (Desktop) --}}
        <div class="hidden lg:flex items-center gap-3">
            {{-- Theme Toggle --}}
            <button
                @click="light = !light; document.documentElement.classList.toggle('light', light); localStorage.setItem('theme', light ? 'light' : 'dark')"
                class="w-10 h-10 flex items-center justify-center rounded-full text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300"
                :aria-label="light ? 'Ativar modo escuro' : 'Ativar modo claro'"
            >
                {{-- Sun (dark mode → click to go light) --}}
                <svg x-show="!light" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                </svg>
                {{-- Moon (light mode → click to go dark) --}}
                <svg x-show="light" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                </svg>
            </button>

            <button @click="$dispatch('comecar-agora', {source: 'cta_header'})"
                    data-magnetic
                    class="text-sm px-6 py-3 rounded-full bg-[var(--accent)] text-white hover:bg-[var(--accent-light)] transition-colors duration-300">
                Iniciar Projeto
            </button>
        </div>

        {{-- Mobile: Theme Toggle + Hamburger --}}
        <div class="flex lg:hidden items-center gap-2">
            {{-- Mobile Theme Toggle --}}
            <button
                @click="light = !light; document.documentElement.classList.toggle('light', light); localStorage.setItem('theme', light ? 'light' : 'dark')"
                class="w-10 h-10 flex items-center justify-center rounded-full text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300"
                :aria-label="light ? 'Ativar modo escuro' : 'Ativar modo claro'"
            >
                <svg x-show="!light" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                </svg>
                <svg x-show="light" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                </svg>
            </button>

            {{-- Hamburger --}}
            <button @click="mobileOpen = !mobileOpen" class="text-[var(--white)]" aria-label="Menu">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="1.5" d="M4 8h16M4 16h16"/>
                </svg>
                <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

    </nav>

    {{-- Mobile Menu Fullscreen --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="lg:hidden fixed inset-0 top-20 bg-[var(--black)] z-40 flex flex-col items-center justify-center gap-8">
        <a href="#servicos" @click="mobileOpen = false" class="text-3xl font-display text-[var(--white)] hover:text-[var(--accent)] transition-colors">Serviços</a>
        <a href="#projetos" @click="mobileOpen = false" class="text-3xl font-display text-[var(--white)] hover:text-[var(--accent)] transition-colors">Projetos</a>
        <a href="#pacotes" @click="mobileOpen = false" class="text-3xl font-display text-[var(--white)] hover:text-[var(--accent)] transition-colors">Pacotes</a>
        <a href="/blog" class="text-3xl font-display text-[var(--white)] hover:text-[var(--accent)] transition-colors">Blog</a>
        <a href="#faq" @click="mobileOpen = false" class="text-3xl font-display text-[var(--white)] hover:text-[var(--accent)] transition-colors">FAQ</a>
        <button @click="$dispatch('comecar-agora', {source: 'cta_header'}); mobileOpen = false"
                class="mt-4 px-8 py-4 rounded-full bg-[var(--accent)] text-white text-lg hover:bg-[var(--accent-light)] transition-colors">
            Iniciar Projeto
        </button>
    </div>
</header>
