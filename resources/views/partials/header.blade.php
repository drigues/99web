{{--
    Header fixo responsivo
    - Desktop: logo | nav central | CTA
    - Mobile: logo | hamburger → overlay fullscreen
    - Scroll: bg transparente → #0F0A1A/95 + backdrop-blur
--}}
<div
    x-data="{
        scrolled: false,
        mobileOpen: false,
        init() {
            window.addEventListener('scroll', () => {
                this.scrolled = window.scrollY > 20
            }, { passive: true })
        }
    }"
    x-on:keydown.escape.window="mobileOpen = false"
>
    {{-- ─── Navbar ─── --}}
    <header
        :class="scrolled
            ? 'bg-[#0F0A1A]/95 backdrop-blur-md border-b border-white/5 shadow-xl shadow-black/20'
            : 'bg-transparent'"
        class="fixed top-0 inset-x-0 z-50 transition-all duration-300"
        role="banner"
    >
        <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between gap-8">

            {{-- Logo --}}
            <a
                href="{{ route('home') }}"
                class="flex-shrink-0 text-2xl font-bold tracking-tight select-none"
                aria-label="99web — Página inicial"
            >
                <span class="text-brand-accent">99web</span>
            </a>

            {{-- Nav Desktop --}}
            <nav
                class="hidden md:flex items-center gap-8"
                aria-label="Navegação principal"
            >
                @foreach ([
                    'Serviços'  => '#servicos',
                    'Projetos'  => '#projetos',
                    'Pacotes'   => '#pacotes',
                    'FAQ'       => '#faq',
                ] as $label => $href)
                    <a
                        href="{{ $href }}"
                        class="text-sm font-medium text-brand-muted hover:text-brand-accent transition-colors duration-200"
                    >{{ $label }}</a>
                @endforeach
                <a
                    href="{{ route('blog.index') }}"
                    class="text-sm font-medium transition-colors duration-200
                           {{ request()->routeIs('blog.*') ? 'text-brand-accent' : 'text-brand-muted hover:text-brand-accent' }}"
                >Blog</a>
            </nav>

            {{-- Direita: CTA + Hamburger --}}
            <div class="flex items-center gap-3">

                {{-- CTA — só visível no desktop --}}
                <button
                    type="button"
                    @click="$dispatch('comecar-agora', { source: 'cta_header' })"
                    class="hidden md:inline-flex items-center px-5 py-2.5 rounded-full text-sm font-semibold text-white
                           transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-brand-primary/40"
                    style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                >
                    Começar Agora
                </button>

                {{-- Hamburger — só visível no mobile --}}
                <button
                    x-on:click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    :aria-label="mobileOpen ? 'Fechar menu' : 'Abrir menu'"
                    class="md:hidden relative w-10 h-10 flex flex-col items-center justify-center gap-1.5
                           rounded-lg hover:bg-white/5 transition-colors"
                >
                    {{-- Linha superior → braço do X --}}
                    <span
                        :class="mobileOpen ? 'rotate-45 translate-y-2' : ''"
                        class="block w-5 h-0.5 bg-white origin-center transition-transform duration-300"
                    ></span>
                    {{-- Linha do meio → some --}}
                    <span
                        :class="mobileOpen ? 'opacity-0 scale-x-0' : ''"
                        class="block w-5 h-0.5 bg-white transition-all duration-300"
                    ></span>
                    {{-- Linha inferior → braço do X --}}
                    <span
                        :class="mobileOpen ? '-rotate-45 -translate-y-2' : ''"
                        class="block w-5 h-0.5 bg-white origin-center transition-transform duration-300"
                    ></span>
                </button>

            </div>
        </div>
    </header>

    {{-- ─── Mobile overlay fullscreen ─── --}}
    <div
        x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-40 flex flex-col items-center justify-center bg-brand-bg md:hidden"
        style="display: none;"
        role="dialog"
        aria-modal="true"
        aria-label="Menu de navegação"
    >
        {{-- Conteúdo do menu com slide-up --}}
        <div
            x-show="mobileOpen"
            x-transition:enter="transition ease-out duration-300 delay-75"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 translate-y-4"
        >
            <nav class="flex flex-col items-center gap-7 text-center" aria-label="Menu mobile">

                @foreach ([
                    'Serviços'  => '#servicos',
                    'Projetos'  => '#projetos',
                    'Pacotes'   => '#pacotes',
                    'FAQ'       => '#faq',
                ] as $label => $href)
                    <a
                        href="{{ $href }}"
                        x-on:click="mobileOpen = false"
                        class="text-2xl font-semibold text-white hover:text-brand-accent transition-colors duration-200"
                    >{{ $label }}</a>
                @endforeach
                <a
                    href="{{ route('blog.index') }}"
                    x-on:click="mobileOpen = false"
                    class="text-2xl font-semibold transition-colors duration-200
                           {{ request()->routeIs('blog.*') ? 'text-brand-accent' : 'text-white hover:text-brand-accent' }}"
                >Blog</a>

                {{-- CTA Mobile --}}
                <button
                    type="button"
                    @click="mobileOpen = false; $dispatch('comecar-agora', { source: 'cta_header_mobile' })"
                    class="mt-4 px-8 py-3.5 rounded-full text-base font-semibold text-white
                           transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-brand-primary/40"
                    style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                >
                    Começar Agora
                </button>

            </nav>
        </div>
    </div>

</div>
