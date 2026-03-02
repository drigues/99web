@extends('layouts.app')

@section('content')

{{-- ══════════════════════════════════════════════════════
     HERO
══════════════════════════════════════════════════════ --}}
<section class="relative min-h-screen flex items-center overflow-hidden pt-16">

    {{-- Gradiente radial roxo no centro-topo --}}
    <div
        class="absolute inset-0 pointer-events-none"
        style="background:
            radial-gradient(ellipse 85% 55% at 50% -5%,
                rgba(124, 58, 237, 0.28) 0%,
                rgba(91, 33, 182, 0.10) 45%,
                transparent 70%
            );"
        aria-hidden="true"
    ></div>

    {{-- Grade decorativa de pontos --}}
    <div
        class="absolute inset-0 pointer-events-none opacity-[0.04]"
        style="background-image: radial-gradient(circle, #a855f7 1px, transparent 1px); background-size: 32px 32px;"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-7xl mx-auto px-6 py-20 w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- ─── Coluna esquerda ─── --}}
            <div>
                {{-- Pill label --}}
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-brand-primary/40 bg-brand-primary/10 mb-6">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-accent opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-accent"></span>
                    </span>
                    <span class="text-xs font-semibold text-brand-accent tracking-wide uppercase">Agência Digital · Portugal</span>
                </div>

                {{-- H1 --}}
                <h1 class="text-4xl lg:text-7xl font-display font-black text-[var(--white)] leading-[1.05] tracking-tight">
                    {{ $settings->get('hero_title_line1', 'Seus clientes estão') }}<br>
                    {{ $settings->get('hero_title_line2', 'à sua procura') }}<br>
                    <span class="text-brand-accent">{{ $settings->get('hero_title_line3', 'na internet!') }}</span>
                </h1>

                {{-- Subtítulo --}}
                <p class="text-lg lg:text-xl font-medium text-[var(--gray)] mt-5 leading-relaxed max-w-lg">
                    {{ $settings->get('hero_subtitle', 'Criamos a sua presença online — seja encontrado pelos seus públicos com um site que converte.') }}
                </p>

                {{-- Botões --}}
                <div class="flex flex-wrap gap-4 mt-8">
                    {{-- CTA primário --}}
                    <button
                        type="button"
                        @click="$dispatch('comecar-agora', { source: 'cta_hero' })"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white
                               transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-brand-primary/40"
                        style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                    >
                        {{ $settings->get('hero_cta_primary', 'Marcar revisão do projeto') }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </button>

                    {{-- CTA secundário --}}
                    <a
                        href="#projetos"
                        class="inline-flex items-center px-6 py-3 rounded-full font-semibold text-[var(--white)]
                               border border-violet-500 hover:bg-violet-500/20 transition-colors duration-200"
                    >
                        {{ $settings->get('hero_cta_secondary', 'Ver casos de sucesso') }}
                    </a>
                </div>

                {{-- Stats / Badges --}}
                <div class="flex flex-wrap gap-8 mt-10 pt-8 border-t border-[var(--border-subtle)]">

                    {{-- 100% Entregas --}}
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-brand-primary/15 border border-brand-primary/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-brand-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-3xl lg:text-5xl font-display font-black text-[var(--white)] leading-none">{{ $settings->get('hero_stat1_value', '100%') }}</div>
                            <div class="text-sm font-medium text-[var(--gray)] mt-0.5">{{ $settings->get('hero_stat1_label', 'Entregas no prazo') }}</div>
                        </div>
                    </div>

                    {{-- Divisor --}}
                    <div class="hidden sm:block w-px bg-[var(--border-color)] self-stretch"></div>

                    {{-- Suporte --}}
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-brand-primary/15 border border-brand-primary/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-brand-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl lg:text-3xl font-display font-bold text-[var(--white)] leading-none">{{ $settings->get('hero_stat2_value', 'Suporte') }}</div>
                            <div class="text-sm font-medium text-[var(--gray)] mt-0.5">{{ $settings->get('hero_stat2_label', 'Resposta em 24/48h') }}</div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ─── Coluna direita: Mockup ─── --}}
            <div class="relative flex justify-center lg:justify-end">

                {{-- Glow atrás do card --}}
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                           w-72 h-72 rounded-full blur-3xl pointer-events-none"
                    style="background: radial-gradient(circle, rgba(124,58,237,0.35) 0%, transparent 70%);"
                    aria-hidden="true"
                ></div>

                {{-- Wrapper relativo para os cards flutuantes --}}
                <div class="relative w-full max-w-sm">

                    {{-- ── Card principal ── --}}
                    <div class="animate-float relative rounded-2xl border border-violet-500/20 bg-[var(--bg-card)] p-5 shadow-2xl shadow-violet-950/50">

                        {{-- Dots estilo browser --}}
                        <div class="flex gap-1.5 mb-5" aria-hidden="true">
                            <div class="w-3 h-3 rounded-full bg-red-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400/80"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400/80"></div>
                        </div>

                        {{-- Badge ESTRATÉGIA DE CRESCIMENTO --}}
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-violet-500/15 border border-violet-500/25 mb-5">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-violet-400"></span>
                            </span>
                            <span class="text-[10px] font-bold text-violet-300 tracking-widest uppercase">Estratégia de Crescimento</span>
                        </div>

                        {{-- Gráfico de barras --}}
                        <div class="flex items-end gap-1.5 h-28 mb-5 px-1" aria-hidden="true">
                            <div class="flex-1 rounded-t-sm bg-violet-900/60"   style="height:33%"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-800/70"   style="height:48%"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-700/70"   style="height:40%"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-600/80"   style="height:62%"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-500/90"   style="height:75%"></div>
                            <div class="flex-1 rounded-t-sm"                    style="height:100%; background: linear-gradient(to top, #7c3aed, #a855f7);"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-500/80"   style="height:82%"></div>
                            <div class="flex-1 rounded-t-sm bg-violet-600/60"   style="height:55%"></div>
                        </div>

                        {{-- Mini stats --}}
                        <div class="grid grid-cols-3 gap-2">
                            <div class="rounded-xl bg-white/5 p-3">
                                <div class="text-sm font-bold text-[var(--white)]">+127%</div>
                                <div class="text-[10px] text-[var(--gray)] mt-0.5">Tráfego</div>
                            </div>
                            <div class="rounded-xl bg-violet-500/15 border border-violet-500/20 p-3">
                                <div class="text-sm font-bold text-violet-300">98/100</div>
                                <div class="text-[10px] text-[var(--gray)] mt-0.5">SEO Score</div>
                            </div>
                            <div class="rounded-xl bg-white/5 p-3">
                                <div class="text-sm font-bold text-[var(--white)]">4.9 ★</div>
                                <div class="text-[10px] text-[var(--gray)] mt-0.5">Avaliação</div>
                            </div>
                        </div>

                        {{-- Barra de progresso --}}
                        <div class="mt-4">
                            <div class="flex justify-between text-[10px] text-[var(--gray)] mb-1.5">
                                <span>Crescimento mensal</span>
                                <span class="text-violet-300 font-semibold">78%</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-white/5 overflow-hidden">
                                <div class="h-full rounded-full w-[78%]"
                                     style="background: linear-gradient(to right, var(--color-brand-cta-from), var(--color-brand-cta-to));"></div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Card flutuante: Projeto entregue (topo direito) ── --}}
                    <div
                        class="animate-float-delayed absolute -top-4 -right-4
                               rounded-xl bg-[var(--bg-card)] border border-violet-500/20 px-3 py-2.5 shadow-xl"
                        aria-hidden="true"
                    >
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-green-500/20 border border-green-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[var(--white)] whitespace-nowrap">Projeto entregue!</div>
                                <div class="text-[10px] text-[var(--gray)]">há 2 minutos</div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Card flutuante: Visitantes (baixo esquerdo) ── --}}
                    <div
                        class="animate-float-slow absolute -bottom-4 -left-4
                               rounded-xl bg-[var(--bg-card)] border border-violet-500/20 px-3.5 py-2.5 shadow-xl"
                        aria-hidden="true"
                    >
                        <div class="flex items-center gap-3">
                            <div class="text-xl font-bold text-violet-400">24k</div>
                            <div>
                                <div class="text-[11px] font-medium text-[var(--white)]">Visitantes/mês</div>
                                <div class="text-[10px] text-green-400 font-semibold">↑ +48% este mês</div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Card flutuante: Clientes (centro direito) ── --}}
                    <div
                        class="animate-float-delayed absolute -right-5 top-1/2 -translate-y-1/2
                               rounded-xl bg-[var(--bg-card)] border border-violet-500/20 px-3 py-2 shadow-xl hidden lg:block"
                        style="animation-delay: 1.2s;"
                        aria-hidden="true"
                    >
                        <div class="text-[10px] text-[var(--gray)] mb-1">Clientes ativos</div>
                        <div class="flex -space-x-2">
                            @foreach (['#7C3AED','#A855F7','#9333EA','#6D28D9'] as $cor)
                                <div class="w-6 h-6 rounded-full border-2 border-[var(--bg-card)]"
                                     style="background-color: {{ $cor }};"></div>
                            @endforeach
                            <div class="w-6 h-6 rounded-full border-2 border-[var(--bg-card)] bg-white/10 flex items-center justify-center">
                                <span class="text-[8px] font-bold text-[var(--gray)]">+9</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- /Coluna direita --}}

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     SERVIÇOS — Visual-first editorial v2
══════════════════════════════════════════════════════ --}}
@include('partials.services-v2')

{{-- ══════════════════════════════════════════════════════
     PORTFÓLIO — Grid assimétrico v2
══════════════════════════════════════════════════════ --}}
@include('partials.portfolio-v2')

{{-- ══════════════════════════════════════════════════════
     PACOTES / PREÇOS
══════════════════════════════════════════════════════ --}}
<section
    id="pacotes"
    class="py-24 bg-brand-bg relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    {{-- Glow de fundo --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[700px] h-72 blur-3xl pointer-events-none"
        style="background: radial-gradient(ellipse, rgba(124,58,237,0.13) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-5xl mx-auto px-6">

        {{-- Cabeçalho --}}
        <div
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="transition-all duration-700 ease-out text-center mb-14"
        >
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Preços</span>
            </div>

            <h2 class="text-3xl lg:text-6xl font-display font-black text-[var(--white)] mb-4">Pacotes</h2>
            <p class="text-base lg:text-lg text-[var(--gray)] max-w-md mx-auto">Planos simples e transparentes</p>
        </div>

        {{-- Grid de cards --}}
        @php
            $packages = [
                [
                    'slug'     => 'essencial',
                    'type'     => 'essencial',
                    'order'    => 'order-2 lg:order-1',
                    'delay'    => 'delay-100',
                ],
                [
                    'slug'     => 'corporativo',
                    'type'     => 'corporativo',
                    'order'    => 'order-1 lg:order-2',
                    'delay'    => 'delay-200',
                ],
                [
                    'slug'     => 'personalizado',
                    'type'     => 'personalizado',
                    'order'    => 'order-3 lg:order-3',
                    'delay'    => 'delay-300',
                ],
            ];
        @endphp

        <div class="grid lg:grid-cols-3 gap-8 items-start">
            @foreach ($packages as $pkg)
                @if (filter_var($settings->get("package_{$pkg['type']}_active", '1'), FILTER_VALIDATE_BOOLEAN))
                    @php
                        $isPopular   = filter_var($settings->get("package_{$pkg['type']}_popular", '0'), FILTER_VALIDATE_BOOLEAN);
                        $name        = $settings->get("package_{$pkg['type']}_name", ucfirst($pkg['type']));
                        $badge       = $settings->get("package_{$pkg['type']}_badge", '');
                        $priceOrig   = $settings->get("package_{$pkg['type']}_price_original", '');
                        $priceFinal  = $settings->get("package_{$pkg['type']}_price_final", '');
                        $ctaText     = $settings->get("package_{$pkg['type']}_cta_text", 'Saber mais');
                        $features    = array_filter(explode("\n", $settings->get("package_{$pkg['type']}_features", '')));
                        $discount    = ($priceOrig && $priceFinal && is_numeric($priceOrig) && is_numeric($priceFinal) && (int)$priceOrig > (int)$priceFinal)
                                       ? round((((int)$priceOrig - (int)$priceFinal) / (int)$priceOrig) * 100) : 0;
                    @endphp

                    <div
                        :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                        class="transition-all duration-700 {{ $pkg['delay'] }} ease-out {{ $pkg['order'] }}"
                    >
                        <article
                            class="relative rounded-2xl p-8 h-full flex flex-col transition-all duration-300
                                   {{ $isPopular
                                      ? 'border border-violet-500 shadow-xl shadow-violet-500/10 hover:shadow-2xl hover:shadow-violet-500/20'
                                      : 'border border-[var(--border-color)] bg-[var(--bg-card)] hover:border-violet-500/40 hover:shadow-lg hover:shadow-violet-950/40' }}"
                            @if ($isPopular) style="background: linear-gradient(160deg, #1E0F3A 0%, #1A1225 60%, #110A1F 100%);" @endif
                        >
                            @if ($isPopular)
                                {{-- Glow interno --}}
                                <div
                                    class="absolute -top-px inset-x-8 h-px"
                                    style="background: linear-gradient(to right, transparent, #7C3AED, transparent);"
                                    aria-hidden="true"
                                ></div>
                            @endif

                            <div class="mb-6">
                                @if ($badge)
                                    @if ($isPopular)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                                                     bg-violet-500/20 border border-violet-500/40
                                                     text-[10px] font-bold text-violet-300 tracking-widest uppercase mb-4">
                                            <span class="relative flex h-1.5 w-1.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-violet-400"></span>
                                            </span>
                                            {{ $badge }}
                                        </span>
                                    @else
                                        <span class="inline-block px-2.5 py-1 rounded-md bg-white/5 border border-[var(--border-color)]
                                                     text-[10px] font-bold text-[var(--gray)] tracking-widest uppercase mb-4">
                                            {{ $badge }}
                                        </span>
                                    @endif
                                @endif

                                <h3 class="text-xl lg:text-2xl font-bold {{ $isPopular ? 'text-white' : 'text-[var(--white)]' }} mb-5">{{ $name }}</h3>

                                <div class="flex items-end gap-2 mb-1">
                                    @if ($priceOrig && is_numeric($priceOrig) && $discount > 0)
                                        <span class="text-lg line-through text-[var(--gray)]">{{ $priceOrig }}€</span>
                                    @endif
                                    <span class="{{ is_numeric($priceFinal) ? 'text-4xl lg:text-6xl' : 'text-3xl lg:text-5xl' }} font-display font-black {{ $isPopular ? 'text-white' : 'text-[var(--white)]' }}">
                                        {{ is_numeric($priceFinal) ? $priceFinal . '€' : $priceFinal }}
                                    </span>
                                </div>
                                @if ($discount > 0)
                                    <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-green-500/15 text-green-400 text-xs font-semibold">
                                        -{{ $discount }}% desconto
                                    </span>
                                @endif
                                <p class="text-xs {{ $isPopular ? 'text-zinc-500' : 'text-[var(--gray)]' }} mt-1">
                                    {{ is_numeric($priceFinal) ? 'pagamento único / valor sem iva' : 'proposta à medida do projeto' }}
                                </p>
                            </div>

                            <a
                                href="{{ route('pacotes.show', $pkg['slug']) }}"
                                class="block w-full py-3 rounded-full text-center text-sm font-semibold transition-all duration-200 mb-8
                                       {{ $isPopular
                                          ? 'text-white hover:scale-[1.02] hover:shadow-lg hover:shadow-brand-primary/40'
                                          : 'text-violet-400 border border-violet-500/50 hover:bg-violet-500/10 hover:border-violet-400' }}"
                                @if ($isPopular) style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);" @endif
                            >
                                {{ $ctaText }}
                            </a>

                            <ul class="space-y-3.5 flex-1">
                                @foreach ($features as $feature)
                                    <li class="flex items-start gap-3">
                                        <div class="mt-0.5 w-4 h-4 rounded-full {{ $isPopular ? 'bg-violet-500/25' : 'bg-violet-500/15' }} flex items-center justify-center flex-shrink-0">
                                            <svg class="w-2.5 h-2.5 {{ $isPopular ? 'text-violet-300' : 'text-violet-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <span class="text-base text-[var(--text-secondary)]">{{ $feature }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </article>
                    </div>
                @endif
            @endforeach
        </div>
        {{-- /Grid --}}

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TESTEMUNHOS — Marquee loop v2
══════════════════════════════════════════════════════ --}}
@include('partials.testimonials-v2')

{{-- ══════════════════════════════════════════════════════
     FAQ — Minimal accordion v2
══════════════════════════════════════════════════════ --}}
@include('partials.faq-v2')

{{-- ══════════════════════════════════════════════════════
     CTA FINAL — Full-width v2
══════════════════════════════════════════════════════ --}}
@include('partials.cta-v2')

@endsection
