@extends('layouts.app')

@section('title', '99web — Agência Digital')
@section('description', 'Criamos soluções digitais modernas e eficientes. Sites, aplicações web e estratégias digitais para impulsionar o seu negócio.')

@section('content')
    {{-- Hero --}}
    <section
        class="min-h-screen flex items-center justify-center"
        style="background: linear-gradient(135deg, var(--color-brand-hero-from) 0%, var(--color-brand-hero-to) 100%);"
    >
        <div class="max-w-5xl mx-auto px-6 text-center">
            <h1 class="text-5xl md:text-7xl font-bold text-brand-text leading-tight mb-6">
                Soluções digitais
                <span class="text-brand-accent">que transformam</span>
                negócios
            </h1>

            <p class="text-xl text-brand-muted max-w-2xl mx-auto mb-10">
                Desenvolvemos sites e aplicações web de alto desempenho,
                combinando design moderno com tecnologia de ponta.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a
                    href="#contato"
                    class="inline-block px-8 py-4 rounded-xl font-semibold text-white transition-transform hover:scale-105"
                    style="background: linear-gradient(135deg, var(--color-brand-cta-from) 0%, var(--color-brand-cta-to) 100%);"
                >
                    Começar projeto
                </a>
                <a
                    href="#servicos"
                    class="inline-block px-8 py-4 rounded-xl font-semibold border border-brand-accent text-brand-accent hover:bg-brand-accent hover:text-white transition-colors"
                    x-data
                    @click.prevent="document.querySelector('#servicos')?.scrollIntoView({ behavior: 'smooth' })"
                >
                    Ver serviços
                </a>
            </div>
        </div>
    </section>

    {{-- Serviços --}}
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
                        @mouseenter="hovered = true"
                        @mouseleave="hovered = false"
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
