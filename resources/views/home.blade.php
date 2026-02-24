@extends('layouts.app')

@section('title', '99web — Agência Digital')
@section('description', 'Criamos a sua presença online. Seja encontrado pelos seus públicos com sites e aplicações web modernas.')

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
                <h1 class="text-4xl lg:text-5xl font-bold text-white leading-tight">
                    Seus clientes estão<br>
                    à sua procura<br>
                    <span class="text-brand-accent">na internet!</span>
                </h1>

                {{-- Subtítulo --}}
                <p class="text-lg text-zinc-400 mt-5 leading-relaxed max-w-lg">
                    Criamos a sua presença online — seja encontrado
                    pelos seus públicos com um site que converte.
                </p>

                {{-- Botões --}}
                <div class="flex flex-wrap gap-4 mt-8">
                    {{-- CTA primário --}}
                    <a
                        href="#contato"
                        class="inline-flex items-center gap-2 px-6 py-3 rounded-full font-semibold text-white
                               transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-brand-primary/40"
                        style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                    >
                        Marcar revisão do projeto
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>

                    {{-- CTA secundário --}}
                    <a
                        href="#projetos"
                        class="inline-flex items-center px-6 py-3 rounded-full font-semibold text-white
                               border border-violet-500 hover:bg-violet-500/20 transition-colors duration-200"
                    >
                        Ver casos de sucesso
                    </a>
                </div>

                {{-- Stats / Badges --}}
                <div class="flex flex-wrap gap-8 mt-10 pt-8 border-t border-white/5">

                    {{-- 100% Entregas --}}
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-brand-primary/15 border border-brand-primary/20 flex items-center justify-center flex-shrink-0">
                            {{-- Sparkles / IA --}}
                            <svg class="w-5 h-5 text-brand-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-2xl font-bold text-white leading-none">100%</div>
                            <div class="text-xs text-zinc-400 mt-0.5">Entregas no prazo</div>
                        </div>
                    </div>

                    {{-- Divisor --}}
                    <div class="hidden sm:block w-px bg-white/10 self-stretch"></div>

                    {{-- Suporte --}}
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-xl bg-brand-primary/15 border border-brand-primary/20 flex items-center justify-center flex-shrink-0">
                            {{-- Headset / Suporte --}}
                            <svg class="w-5 h-5 text-brand-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-lg font-bold text-white leading-none">Suporte</div>
                            <div class="text-xs text-zinc-400 mt-0.5">Resposta em 24/48h</div>
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
                    <div class="animate-float relative rounded-2xl border border-violet-500/20 bg-[#14102A] p-5 shadow-2xl shadow-violet-950/50">

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
                                <div class="text-sm font-bold text-white">+127%</div>
                                <div class="text-[10px] text-zinc-400 mt-0.5">Tráfego</div>
                            </div>
                            <div class="rounded-xl bg-violet-500/15 border border-violet-500/20 p-3">
                                <div class="text-sm font-bold text-violet-300">98/100</div>
                                <div class="text-[10px] text-zinc-400 mt-0.5">SEO Score</div>
                            </div>
                            <div class="rounded-xl bg-white/5 p-3">
                                <div class="text-sm font-bold text-white">4.9 ★</div>
                                <div class="text-[10px] text-zinc-400 mt-0.5">Avaliação</div>
                            </div>
                        </div>

                        {{-- Barra de progresso --}}
                        <div class="mt-4">
                            <div class="flex justify-between text-[10px] text-zinc-400 mb-1.5">
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
                               rounded-xl bg-[#1C1535] border border-violet-500/20 px-3 py-2.5 shadow-xl"
                        aria-hidden="true"
                    >
                        <div class="flex items-center gap-2.5">
                            <div class="w-7 h-7 rounded-full bg-green-500/20 border border-green-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-white whitespace-nowrap">Projeto entregue!</div>
                                <div class="text-[10px] text-zinc-400">há 2 minutos</div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Card flutuante: Visitantes (baixo esquerdo) ── --}}
                    <div
                        class="animate-float-slow absolute -bottom-4 -left-4
                               rounded-xl bg-[#1C1535] border border-violet-500/20 px-3.5 py-2.5 shadow-xl"
                        aria-hidden="true"
                    >
                        <div class="flex items-center gap-3">
                            <div class="text-xl font-bold text-violet-400">24k</div>
                            <div>
                                <div class="text-[11px] font-medium text-white">Visitantes/mês</div>
                                <div class="text-[10px] text-green-400 font-semibold">↑ +48% este mês</div>
                            </div>
                        </div>
                    </div>

                    {{-- ── Card flutuante: Clientes (centro direito) ── --}}
                    <div
                        class="animate-float-delayed absolute -right-5 top-1/2 -translate-y-1/2
                               rounded-xl bg-[#1C1535] border border-violet-500/20 px-3 py-2 shadow-xl hidden lg:block"
                        style="animation-delay: 1.2s;"
                        aria-hidden="true"
                    >
                        <div class="text-[10px] text-zinc-400 mb-1">Clientes ativos</div>
                        <div class="flex -space-x-2">
                            @foreach (['#7C3AED','#A855F7','#9333EA','#6D28D9'] as $cor)
                                <div class="w-6 h-6 rounded-full border-2 border-[#1C1535]"
                                     style="background-color: {{ $cor }};"></div>
                            @endforeach
                            <div class="w-6 h-6 rounded-full border-2 border-[#1C1535] bg-white/10 flex items-center justify-center">
                                <span class="text-[8px] font-bold text-zinc-300">+9</span>
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
     SERVIÇOS
══════════════════════════════════════════════════════ --}}
<section id="servicos" class="py-24 bg-brand-section">
    <div class="max-w-5xl mx-auto px-6">
        <h2 class="text-4xl font-bold text-brand-text text-center mb-4">
            O que fazemos
        </h2>
        <p class="text-brand-muted text-center mb-16 max-w-xl mx-auto">
            Do conceito ao lançamento, cuidamos de cada etapa do seu projeto digital.
        </p>

        <div class="grid md:grid-cols-3 gap-8">
            @foreach ([
                ['titulo' => 'Desenvolvimento Web', 'desc' => 'Sites e aplicações performáticas construídos com as melhores tecnologias do mercado.'],
                ['titulo' => 'UI/UX Design', 'desc' => 'Interfaces intuitivas e esteticamente impecáveis que encantam os usuários.'],
                ['titulo' => 'Estratégia Digital', 'desc' => 'Planejamento e execução de presença digital para maximizar resultados.'],
            ] as $servico)
                <article
                    class="p-8 rounded-2xl border border-brand-primary/30 bg-brand-bg hover:border-brand-accent transition-colors"
                    x-data="{ hovered: false }"
                    x-on:mouseenter="hovered = true"
                    x-on:mouseleave="hovered = false"
                    :class="{ 'shadow-lg shadow-brand-primary/20': hovered }"
                >
                    <h3 class="text-xl font-semibold text-brand-text mb-3">{{ $servico['titulo'] }}</h3>
                    <p class="text-brand-muted leading-relaxed">{{ $servico['desc'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@endsection
