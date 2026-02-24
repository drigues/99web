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
     BLOCO 1 — WEBSITES PROFISSIONAL  (texto esq | mockup dir)
══════════════════════════════════════════════════════ --}}
<section
    id="servicos"
    class="py-20 bg-brand-bg relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    {{-- Gradiente decorativo lateral --}}
    <div
        class="absolute -left-40 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full blur-3xl pointer-events-none"
        style="background: radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Texto --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 ease-out"
            >
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                    <svg class="w-3 h-3 text-violet-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Websites</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                    Websites Profissional
                </h2>

                <p class="text-zinc-400 leading-relaxed mb-8 max-w-md">
                    Design moderno, adaptado a todos os dispositivos.
                    O seu negócio merece estar online com um website sólido.
                </p>

                <ul class="space-y-4">
                    @foreach ([
                        'Otimizado para aparecer no Google',
                        'Planos com domínio e alojamento incluído',
                        'Rápido, seguro e construído para o seu tempo',
                    ] as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-violet-500/20 border border-violet-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-zinc-300">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Mockup — browser website --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-200 ease-out"
            >
                <div class="rounded-2xl border border-violet-500/20 bg-[#14102A] overflow-hidden shadow-2xl shadow-violet-950/40">

                    {{-- Barra do browser --}}
                    <div class="bg-[#1E1535] px-4 py-2.5 flex items-center gap-3 border-b border-white/5">
                        <div class="flex gap-1.5" aria-hidden="true">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/70"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-400/70"></div>
                        </div>
                        <div class="flex-1 bg-white/5 rounded-md px-3 py-1 flex items-center gap-2">
                            <svg class="w-3 h-3 text-green-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            <span class="text-[10px] text-zinc-500">https://seunegocio.pt</span>
                        </div>
                    </div>

                    {{-- Conteúdo simulado do site --}}
                    <div class="p-5" aria-hidden="true">
                        {{-- Fake nav --}}
                        <div class="flex items-center justify-between mb-5">
                            <div class="h-3 w-16 rounded-full bg-violet-400/50"></div>
                            <div class="flex gap-2">
                                <div class="h-2 w-8 rounded-full bg-white/10"></div>
                                <div class="h-2 w-8 rounded-full bg-white/10"></div>
                                <div class="h-2 w-8 rounded-full bg-white/10"></div>
                                <div class="h-6 w-16 rounded-full bg-violet-600/60"></div>
                            </div>
                        </div>

                        {{-- Fake hero --}}
                        <div class="rounded-xl p-5 mb-4" style="background: linear-gradient(135deg, #1A0533 0%, #0F0A1A 100%);">
                            <div class="h-5 w-3/4 rounded-full bg-white/30 mb-2.5"></div>
                            <div class="h-3 w-1/2 rounded-full bg-white/15 mb-5"></div>
                            <div class="h-8 w-28 rounded-full" style="background: linear-gradient(135deg, #7C3AED, #9333EA);"></div>
                        </div>

                        {{-- Fake feature cards --}}
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            <div class="rounded-xl bg-white/5 p-3 h-14"></div>
                            <div class="rounded-xl bg-violet-500/10 border border-violet-500/20 p-3 h-14"></div>
                            <div class="rounded-xl bg-white/5 p-3 h-14"></div>
                        </div>

                        {{-- Badge PageSpeed --}}
                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-500/15 border border-green-500/25">
                                <div class="w-1.5 h-1.5 rounded-full bg-green-400"></div>
                                <span class="text-[10px] font-semibold text-green-400">PageSpeed 98/100</span>
                            </div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-500/15 border border-blue-500/25">
                                <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
                                <span class="text-[10px] font-semibold text-blue-400">SSL Ativo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     BLOCO 2 — SISTEMAS CORPORATIVOS  (mockup esq | texto dir)
══════════════════════════════════════════════════════ --}}
<section
    class="py-20 bg-brand-section relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    <div
        class="absolute -right-40 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full blur-3xl pointer-events-none"
        style="background: radial-gradient(circle, rgba(124,58,237,0.10) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Mockup — dashboard  (aparece primeiro no desktop, segundo no mobile) --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-200 ease-out order-2 lg:order-1"
            >
                <div class="rounded-2xl border border-violet-500/20 bg-[#14102A] p-5 shadow-2xl shadow-violet-950/40" aria-hidden="true">

                    {{-- Header do dashboard --}}
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <div class="text-xs font-semibold text-zinc-200 mb-0.5">Dashboard Corporativo</div>
                            <div class="text-[10px] text-zinc-500">Atualizado agora mesmo</div>
                        </div>
                        <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full bg-green-500/15 border border-green-500/25">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-green-400"></span>
                            </span>
                            <span class="text-[10px] font-bold text-green-400">+250% Performance</span>
                        </div>
                    </div>

                    {{-- Barras de progresso horizontais --}}
                    @foreach ([
                        ['label' => 'Velocidade de processos', 'pct' => 95, 'val' => '95%'],
                        ['label' => 'Eficiência operacional',  'pct' => 82, 'val' => '82%'],
                        ['label' => 'Automação de tarefas',    'pct' => 78, 'val' => '78%'],
                        ['label' => 'Relatórios em tempo real','pct' => 90, 'val' => '90%'],
                    ] as $kpi)
                        <div class="mb-3.5">
                            <div class="flex justify-between text-[10px] mb-1.5">
                                <span class="text-zinc-400">{{ $kpi['label'] }}</span>
                                <span class="text-violet-300 font-semibold">{{ $kpi['val'] }}</span>
                            </div>
                            <div class="h-1.5 rounded-full bg-white/5 overflow-hidden">
                                <div
                                    class="h-full rounded-full"
                                    style="width: {{ $kpi['pct'] }}%; background: linear-gradient(to right, #7C3AED, #A855F7);"
                                ></div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Stats cards --}}
                    <div class="grid grid-cols-2 gap-2 mt-5">
                        <div class="rounded-xl bg-white/5 p-3">
                            <div class="text-xl font-bold text-white">142</div>
                            <div class="text-[10px] text-zinc-400 mt-0.5">Tarefas automatizadas</div>
                        </div>
                        <div class="rounded-xl bg-violet-500/15 border border-violet-500/20 p-3">
                            <div class="text-xl font-bold text-violet-300">38h</div>
                            <div class="text-[10px] text-zinc-400 mt-0.5">Poupadas por semana</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Texto --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 ease-out order-1 lg:order-2"
            >
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                    <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                    <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Sistemas</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                    Sistemas Corporativos
                </h2>

                <p class="text-zinc-400 leading-relaxed mb-8 max-w-md">
                    Aumente a rapidez dos seus processos. Coloque o seu negócio
                    na frente e torne-o mais eficiente.
                </p>

                <ul class="space-y-4">
                    @foreach ([
                        'Performance para criar soluções imediatas',
                        'Controle a sua equipa com dados',
                        'Gestão de conteúdos multiplataformas',
                    ] as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-violet-500/20 border border-violet-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-zinc-300">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     BLOCO 3 — GOOGLE MAPS  (texto esq | mockup dir)
══════════════════════════════════════════════════════ --}}
<section
    class="py-20 bg-brand-bg relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    <div
        class="absolute -left-40 top-1/2 -translate-y-1/2 w-96 h-96 rounded-full blur-3xl pointer-events-none"
        style="background: radial-gradient(circle, rgba(124,58,237,0.12) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="max-w-7xl mx-auto px-6">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">

            {{-- Texto --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 ease-out"
            >
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                    <svg class="w-3 h-3 text-violet-400" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Google Maps</span>
                </div>

                <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                    Google Maps
                </h2>

                <p class="text-zinc-400 leading-relaxed mb-8 max-w-md">
                    Otimizamos o seu perfil Google Maps para que os clientes
                    locais o encontrem primeiro — antes da concorrência.
                </p>

                <ul class="space-y-4">
                    @foreach ([
                        'O seu negócio visível a clientes nas pesquisas do Google',
                        'Perfil otimizado com foto e recursos do Google Maps',
                        'Integração com Google My Business para máxima visibilidade',
                    ] as $item)
                        <li class="flex items-start gap-3">
                            <div class="mt-0.5 w-5 h-5 rounded-full bg-violet-500/20 border border-violet-500/30 flex items-center justify-center flex-shrink-0">
                                <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-zinc-300">{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Mockup — Google Maps --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-200 ease-out"
            >
                <div class="rounded-2xl border border-violet-500/20 bg-[#14102A] overflow-hidden shadow-2xl shadow-violet-950/40" aria-hidden="true">

                    {{-- Mapa falso --}}
                    <div class="relative h-44" style="background-color: #1a1f35;">

                        {{-- Grade de ruas simulada --}}
                        <div
                            class="absolute inset-0 opacity-15"
                            style="background-image:
                                linear-gradient(rgba(255,255,255,0.4) 1px, transparent 1px),
                                linear-gradient(90deg, rgba(255,255,255,0.4) 1px, transparent 1px);
                                background-size: 24px 24px;"
                        ></div>

                        {{-- Ruas principais --}}
                        <div class="absolute" style="top:42%; left:0; right:0; height:3px; background:rgba(255,255,255,0.12);"></div>
                        <div class="absolute" style="top:0; bottom:0; left:35%; width:3px; background:rgba(255,255,255,0.12);"></div>
                        <div class="absolute" style="top:0; bottom:0; left:65%; width:2px; background:rgba(255,255,255,0.07);"></div>
                        <div class="absolute" style="top:70%; left:0; right:0; height:2px; background:rgba(255,255,255,0.07);"></div>

                        {{-- Pin central --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="relative">
                                <div class="absolute -inset-6 rounded-full bg-violet-500/10 animate-ping" style="animation-duration: 2.5s;"></div>
                                <div class="absolute -inset-3 rounded-full bg-violet-500/15"></div>
                                <div class="relative w-11 h-11 rounded-full border-2 border-white flex items-center justify-center shadow-xl shadow-violet-600/50"
                                     style="background: linear-gradient(135deg, #7C3AED, #9333EA);">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- Badge +180% --}}
                        <div class="absolute top-3 right-3 px-2.5 py-1 rounded-lg bg-green-500/20 border border-green-500/30">
                            <span class="text-xs font-bold text-green-400">↑ +180% visibilidade</span>
                        </div>

                    </div>

                    {{-- Card do negócio --}}
                    <div class="p-4">
                        <div class="rounded-xl bg-white/5 p-3.5 mb-3">
                            <div class="flex items-start gap-3">
                                <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                                     style="background: linear-gradient(135deg, #7C3AED, #9333EA);">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="text-sm font-semibold text-white mb-1 truncate">O Seu Negócio, Lda.</div>
                                    <div class="flex items-center gap-1 mb-1">
                                        @for ($i = 0; $i < 5; $i++)
                                            <svg class="w-3 h-3 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                        <span class="text-[10px] text-zinc-400 ml-1">5.0 · 247 avaliações</span>
                                    </div>
                                    <div class="text-[10px] text-zinc-500">Lisboa, Portugal</div>
                                </div>
                                <div class="px-2 py-0.5 rounded-full bg-blue-500/15 border border-blue-500/20 flex-shrink-0">
                                    <span class="text-[9px] font-bold text-blue-300">✓ Verificado</span>
                                </div>
                            </div>
                        </div>

                        {{-- Stats de pesquisa --}}
                        <div class="grid grid-cols-3 gap-2">
                            <div class="rounded-lg bg-white/5 p-2 text-center">
                                <div class="text-sm font-bold text-white">3.2k</div>
                                <div class="text-[9px] text-zinc-400 mt-0.5">Pesquisas</div>
                            </div>
                            <div class="rounded-lg bg-violet-500/15 border border-violet-500/20 p-2 text-center">
                                <div class="text-sm font-bold text-violet-300">847</div>
                                <div class="text-[9px] text-zinc-400 mt-0.5">Cliques</div>
                            </div>
                            <div class="rounded-lg bg-white/5 p-2 text-center">
                                <div class="text-sm font-bold text-white">124</div>
                                <div class="text-[9px] text-zinc-400 mt-0.5">Rotas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     PORTFÓLIO — "Criamos para a tua empresa"
══════════════════════════════════════════════════════ --}}
<section
    id="projetos"
    class="py-24 bg-brand-section relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    {{-- Glow central de fundo --}}
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-64 blur-3xl pointer-events-none"
        style="background: radial-gradient(ellipse, rgba(124,58,237,0.12) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-7xl mx-auto px-6">

        {{-- Cabeçalho --}}
        <div
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="transition-all duration-700 ease-out text-center mb-12"
        >
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                <svg class="w-3 h-3 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Portfólio</span>
            </div>

            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
                Criamos para a tua empresa
            </h2>
            <p class="text-zinc-400 max-w-xl mx-auto">
                Websites e sistemas adaptados à realidade da tua empresa
            </p>
        </div>

        {{-- Tabs --}}
        <div
            x-data="{ tab: 'websites' }"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="transition-all duration-700 delay-150 ease-out"
        >
            {{-- Tab buttons --}}
            <div class="flex justify-center mb-10">
                <div class="inline-flex p-1 rounded-xl bg-white/5 border border-white/10 gap-1">

                    <button
                        x-on:click="tab = 'websites'"
                        :class="tab === 'websites'
                            ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30'
                            : 'text-zinc-400 hover:text-zinc-200'"
                        class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200"
                    >
                        Websites
                    </button>

                    <button
                        x-on:click="tab = 'sistemas'"
                        :class="tab === 'sistemas'
                            ? 'bg-brand-primary text-white shadow-lg shadow-brand-primary/30'
                            : 'text-zinc-400 hover:text-zinc-200'"
                        class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all duration-200"
                    >
                        Sistemas Corporativos
                    </button>

                </div>
            </div>

            {{-- ── Painel: Websites ── --}}
            <div
                x-show="tab === 'websites'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projetos['websites'] as $projeto)
                        @include('partials.portfolio-card', [
                            'projeto'   => $projeto,
                            'categoria' => 'websites',
                        ])
                    @endforeach
                </div>
            </div>

            {{-- ── Painel: Sistemas ── --}}
            <div
                x-show="tab === 'sistemas'"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                style="display: none;"
            >
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($projetos['sistemas'] as $projeto)
                        @include('partials.portfolio-card', [
                            'projeto'   => $projeto,
                            'categoria' => 'sistemas',
                        ])
                    @endforeach
                </div>
            </div>

        </div>
        {{-- /Tabs --}}

    </div>
</section>

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

            <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">Pacotes</h2>
            <p class="text-zinc-400 max-w-md mx-auto">Planos simples e transparentes</p>
        </div>

        {{-- Grid de cards --}}
        <div class="grid lg:grid-cols-3 gap-8 items-start">

            {{-- ── CARD 1 — Web Essencial ── --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-100 ease-out order-2 lg:order-1"
            >
                <article class="rounded-2xl border border-violet-500/20 bg-[#1A1225] p-8 h-full flex flex-col
                                hover:border-violet-500/40 hover:shadow-lg hover:shadow-violet-950/40
                                transition-all duration-300">

                    <div class="mb-6">
                        <span class="inline-block px-2.5 py-1 rounded-md bg-white/5 border border-white/10
                                     text-[10px] font-bold text-zinc-400 tracking-widest uppercase mb-4">
                            Starter
                        </span>
                        <h3 class="text-xl font-bold text-white mb-5">Web Essencial</h3>

                        <div class="flex items-end gap-1.5 mb-1">
                            <span class="text-4xl font-bold text-white">399€</span>
                        </div>
                        <p class="text-xs text-zinc-500">pagamento único</p>
                    </div>

                    <a
                        href="#contato"
                        class="block w-full py-3 rounded-full text-center text-sm font-semibold text-violet-400
                               border border-violet-500/50 hover:bg-violet-500/10 hover:border-violet-400
                               transition-all duration-200 mb-8"
                    >
                        Garantir o meu website
                    </a>

                    <ul class="space-y-3.5 flex-1">
                        @foreach ([
                            'Design profissional e responsivo',
                            'Até 5 páginas',
                            'Formulário de contacto',
                            'SEO básico',
                            'Entrega em 7–14 dias',
                            'Alojamento e domínio incluído (1 ano)',
                        ] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="mt-0.5 w-4 h-4 rounded-full bg-violet-500/15 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-2.5 h-2.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-zinc-300">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>

            {{-- ── CARD 2 — Web Corporativo (DESTACADO) ── --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-200 ease-out order-1 lg:order-2"
            >
                <article
                    class="relative rounded-2xl border border-violet-500 p-8 h-full flex flex-col
                           shadow-xl shadow-violet-500/10 hover:shadow-2xl hover:shadow-violet-500/20
                           transition-all duration-300"
                    style="background: linear-gradient(160deg, #1E0F3A 0%, #1A1225 60%, #110A1F 100%);"
                >
                    {{-- Glow interno --}}
                    <div
                        class="absolute -top-px inset-x-8 h-px"
                        style="background: linear-gradient(to right, transparent, #7C3AED, transparent);"
                        aria-hidden="true"
                    ></div>

                    <div class="mb-6">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                                     bg-violet-500/20 border border-violet-500/40
                                     text-[10px] font-bold text-violet-300 tracking-widest uppercase mb-4">
                            <span class="relative flex h-1.5 w-1.5">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-violet-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-violet-400"></span>
                            </span>
                            Mais Popular
                        </span>
                        <h3 class="text-xl font-bold text-white mb-5">Web Corporativo</h3>

                        <div class="flex items-end gap-1.5 mb-1">
                            <span class="text-4xl font-bold text-white">599€</span>
                        </div>
                        <p class="text-xs text-zinc-500">pagamento único</p>
                    </div>

                    <a
                        href="#contato"
                        class="block w-full py-3 rounded-full text-center text-sm font-semibold text-white
                               transition-all duration-200 hover:scale-[1.02] hover:shadow-lg hover:shadow-brand-primary/40 mb-8"
                        style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                    >
                        Escolher este plano
                    </a>

                    <ul class="space-y-3.5 flex-1">
                        @foreach ([
                            'Design profissional e responsivo',
                            'Até 10 páginas',
                            'Formulário de contacto',
                            'SEO básico + avançado',
                            'Integração com redes sociais',
                            'Google Maps + Analytics',
                            'Blog integrado',
                            'Suporte prioritário 30 dias',
                        ] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="mt-0.5 w-4 h-4 rounded-full bg-violet-500/25 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-2.5 h-2.5 text-violet-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-zinc-200">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>

            {{-- ── CARD 3 — Projetos Personalizados ── --}}
            <div
                :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                class="transition-all duration-700 delay-300 ease-out order-3 lg:order-3"
            >
                <article class="rounded-2xl border border-violet-500/20 bg-[#1A1225] p-8 h-full flex flex-col
                                hover:border-violet-500/40 hover:shadow-lg hover:shadow-violet-950/40
                                transition-all duration-300">

                    <div class="mb-6">
                        <span class="inline-block px-2.5 py-1 rounded-md bg-white/5 border border-white/10
                                     text-[10px] font-bold text-zinc-400 tracking-widest uppercase mb-4">
                            Custom
                        </span>
                        <h3 class="text-xl font-bold text-white mb-5">Projetos Personalizados</h3>

                        <div class="flex items-end gap-1.5 mb-1">
                            <span class="text-3xl font-bold text-white">Sob consulta</span>
                        </div>
                        <p class="text-xs text-zinc-500">proposta à medida do projeto</p>
                    </div>

                    <a
                        href="#contato"
                        class="block w-full py-3 rounded-full text-center text-sm font-semibold text-violet-400
                               border border-violet-500/50 hover:bg-violet-500/10 hover:border-violet-400
                               transition-all duration-200 mb-8"
                    >
                        Falar sobre o projeto
                    </a>

                    <ul class="space-y-3.5 flex-1">
                        @foreach ([
                            'Sistemas web à medida',
                            'E-commerce e lojas digitais',
                            'Integrações com APIs',
                            'Dashboards e painéis admin',
                            'Manutenção e suporte contínuo',
                        ] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="mt-0.5 w-4 h-4 rounded-full bg-violet-500/15 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-2.5 h-2.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-sm text-zinc-300">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            </div>

        </div>
        {{-- /Grid --}}

    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     TESTEMUNHOS
══════════════════════════════════════════════════════ --}}
<section
    class="py-24 bg-brand-section relative overflow-hidden"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    <div
        class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-64 blur-3xl pointer-events-none"
        style="background: radial-gradient(ellipse, rgba(124,58,237,0.10) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-5xl mx-auto px-6">

        {{-- Cabeçalho --}}
        <div
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
            class="transition-all duration-700 ease-out text-center mb-14"
        >
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-5">
                <svg class="w-3 h-3 text-violet-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Testemunhos</span>
            </div>

            <h2 class="text-3xl lg:text-4xl font-bold text-white">
                O que dizem os nossos clientes
            </h2>
        </div>

        {{-- Grid de testemunhos --}}
        <div class="grid lg:grid-cols-3 gap-8">

            @foreach ([
                [
                    'texto'   => 'Foi a melhor decisão que tomei para o meu negócio. O site ficou incrível e os clientes aumentaram significativamente.',
                    'nome'    => 'João Santos',
                    'cargo'   => 'CEO · Restaurante Mar Aberto',
                    'iniciais'=> 'JS',
                    'cor'     => 'linear-gradient(135deg, #7C3AED, #9333EA)',
                ],
                [
                    'texto'   => 'Trabalho de excelente qualidade e atenção ao detalhe. Recomendo a toda a gente que precise de presença online.',
                    'nome'    => 'Ana Costa',
                    'cargo'   => 'Fundadora · Studio AC Design',
                    'iniciais'=> 'AC',
                    'cor'     => 'linear-gradient(135deg, #6D28D9, #7C3AED)',
                ],
                [
                    'texto'   => 'Profissionais de confiança. Entrega rápida, comunicação clara e o resultado superou todas as expectativas.',
                    'nome'    => 'Tiago Rodriguez',
                    'cargo'   => 'Diretor · TechFlow Solutions',
                    'iniciais'=> 'TR',
                    'cor'     => 'linear-gradient(135deg, #9333EA, #A855F7)',
                ],
            ] as $i => $testemunho)
                <article
                    :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
                    class="transition-all duration-700 ease-out
                           bg-[#1A1225] rounded-xl p-6 border border-violet-500/10
                           hover:border-violet-500/30 hover:shadow-lg hover:shadow-violet-950/40
                           flex flex-col gap-5"
                    :style="`transition-delay: {{ $i * 100 + 100 }}ms`"
                >
                    {{-- Estrelas --}}
                    <div class="flex gap-0.5" aria-label="5 estrelas">
                        @for ($s = 0; $s < 5; $s++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>

                    {{-- Citação --}}
                    <blockquote class="flex-1 text-zinc-300 italic leading-relaxed text-sm">
                        "{{ $testemunho['texto'] }}"
                    </blockquote>

                    {{-- Autor --}}
                    <div class="flex items-center gap-3 pt-4 border-t border-white/5">
                        {{-- Avatar com iniciais --}}
                        <div
                            class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0
                                   text-sm font-bold text-white select-none"
                            style="background: {{ $testemunho['cor'] }};"
                            aria-hidden="true"
                        >
                            {{ $testemunho['iniciais'] }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $testemunho['nome'] }}</div>
                            <div class="text-xs text-zinc-500 mt-0.5">{{ $testemunho['cargo'] }}</div>
                        </div>
                    </div>
                </article>
            @endforeach

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     FAQ
══════════════════════════════════════════════════════ --}}
<section
    id="faq"
    class="py-24 bg-[#0F0A1A]"
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
>
    <div class="max-w-3xl mx-auto px-6">

        {{-- Cabeçalho --}}
        <div
            class="text-center mb-14 transition-all duration-700"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-violet-500/30 bg-violet-500/10 text-violet-300 text-xs font-medium tracking-wide uppercase mb-4">
                Dúvidas
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-3">
                Perguntas Frequentes
            </h2>
            <p class="text-zinc-400 text-base max-w-xl mx-auto">
                Tudo o que precisa de saber
            </p>
        </div>

        {{-- Accordion --}}
        <div
            x-data="{ open: null }"
            class="divide-y divide-zinc-800 border border-zinc-800 rounded-2xl overflow-hidden transition-all duration-700 delay-150"
            :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >

            @php
            $faqs = [
                [
                    'pergunta' => 'Preciso de ter conhecimentos técnicos para gerir o meu site?',
                    'resposta'  => 'Não. Todos os nossos sites são entregues com um painel de gestão simples e intuitivo. Formamos a sua equipa numa sessão de onboarding e ficamos disponíveis sempre que precisar de ajuda.',
                ],
                [
                    'pergunta' => 'O domínio e o alojamento estão incluídos?',
                    'resposta'  => 'No primeiro ano, o domínio e o alojamento premium estão incluídos no preço do pacote. A partir do segundo ano, a renovação é cobrada separadamente — geralmente entre 80€ e 150€/ano, dependendo do plano.',
                ],
                [
                    'pergunta' => 'Qual é o prazo de entrega de um website?',
                    'resposta'  => 'Um website standard fica pronto em 7 a 14 dias úteis após recebermos todos os conteúdos (textos, imagens, logótipo). Projetos mais complexos, como lojas online ou sistemas, têm prazos acordados no briefing.',
                ],
                [
                    'pergunta' => 'Posso fazer alterações ao site depois de entregue?',
                    'resposta'  => 'Sim. Nos primeiros 30 dias estão incluídas revisões ilimitadas sem custo. Após esse período, pode contratar o nosso plano de manutenção mensal ou pedir alterações pontuais mediante orçamento.',
                ],
                [
                    'pergunta' => 'O que acontece ao fim de 12 meses?',
                    'resposta'  => 'O site continua a ser seu para sempre. A subscrição anual cobre o alojamento, atualizações de segurança e suporte prioritário. Pode cancelar a qualquer momento e migrar o site para outro servidor.',
                ],
                [
                    'pergunta' => 'Posso acompanhar as estatísticas do meu site?',
                    'resposta'  => 'Sim. Integramos o Google Analytics 4 e/ou o Google Search Console em todos os projetos. Pode ver em tempo real quantas pessoas visitam o seu site, de onde vêm e quais as páginas mais populares.',
                ],
            ];
            @endphp

            @foreach ($faqs as $index => $faq)
            <div>
                {{-- Botão pergunta --}}
                <button
                    type="button"
                    class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left
                           text-sm font-medium text-white transition-colors duration-200
                           hover:text-violet-400 focus:outline-none focus-visible:ring-2
                           focus-visible:ring-violet-500 focus-visible:ring-inset"
                    x-on:click="open = open === {{ $index }} ? null : {{ $index }}"
                    :aria-expanded="open === {{ $index }}"
                >
                    <span>{{ $faq['pergunta'] }}</span>

                    {{-- Chevron --}}
                    <svg
                        class="w-4 h-4 flex-shrink-0 text-violet-400 transition-transform duration-300"
                        :class="open === {{ $index }} ? 'rotate-180' : ''"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                        aria-hidden="true"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Resposta --}}
                <div
                    x-show="open === {{ $index }}"
                    x-transition:enter="transition ease-out duration-250"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    style="display: none;"
                >
                    <div class="px-6 pb-5 text-sm text-zinc-400 leading-relaxed">
                        {{ $faq['resposta'] }}
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>


{{-- ══════════════════════════════════════════════════════
     CTA FINAL
══════════════════════════════════════════════════════ --}}
<section
    id="contato"
    class="py-24 relative overflow-hidden"
    style="background: linear-gradient(135deg, #6D28D9 0%, #5B21B6 40%, #4C1D95 100%);"
>
    {{-- Decoração de fundo: grade de pontos --}}
    <div
        class="absolute inset-0 pointer-events-none opacity-[0.07]"
        style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 28px 28px;"
        aria-hidden="true"
    ></div>

    {{-- Glows --}}
    <div
        class="absolute -top-20 left-1/4 w-80 h-80 rounded-full blur-3xl pointer-events-none"
        style="background: radial-gradient(circle, rgba(167,139,250,0.25) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>
    <div
        class="absolute -bottom-20 right-1/4 w-80 h-80 rounded-full blur-3xl pointer-events-none"
        style="background: radial-gradient(circle, rgba(124,58,237,0.30) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-2xl mx-auto px-6 text-center">

        {{-- Pill --}}
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/20 bg-white/10 text-white/80 text-xs font-medium tracking-wide uppercase mb-6">
            <span class="relative flex h-1.5 w-1.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-white"></span>
            </span>
            Fale connosco hoje
        </span>

        {{-- Título --}}
        <h2 class="text-4xl md:text-5xl font-bold text-white leading-tight mb-5">
            Vamos conversar?
        </h2>

        {{-- Subtítulo --}}
        <p class="text-lg text-white/75 leading-relaxed mb-10 max-w-lg mx-auto">
            Fale com a 99web e construa uma base digital sólida para o teu negócio.
        </p>

        {{-- Botão --}}
        <a
            href="mailto:geral@99web.pt"
            class="inline-flex items-center gap-2.5 px-8 py-4 rounded-full
                   bg-white text-violet-700 font-bold text-base
                   hover:shadow-xl hover:shadow-violet-900/50 hover:scale-105
                   transition-all duration-200"
        >
            Falar com o consultor
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>

        {{-- Micro-texto --}}
        <p class="mt-5 text-sm text-white/50">
            Sem compromisso. Sem complicações. Resposta rápida.
        </p>

    </div>
</section>

@endsection
