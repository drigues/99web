<section class="py-32 lg:py-40 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <x-section-label text="Testemunhos" />

        <h2 class="text-4xl lg:text-6xl font-display leading-tight max-w-3xl mb-16" data-animate="fade-up">
            O que dizem os nossos clientes
        </h2>

    </div>

    <!-- Swiper Slider -->
    <div class="swiper testimonials-swiper" data-animate="fade-in">
        <div class="swiper-wrapper">

            @foreach ([
                [
                    'texto' => 'Foi a melhor decisão que tomei para o meu negócio. O site ficou incrível e os clientes aumentaram significativamente.',
                    'nome'  => 'João Santos',
                    'cargo' => 'CEO · Restaurante Mar Aberto',
                ],
                [
                    'texto' => 'Trabalho de excelente qualidade e atenção ao detalhe. Recomendo a toda a gente que precise de presença online.',
                    'nome'  => 'Ana Costa',
                    'cargo' => 'Fundadora · Studio AC Design',
                ],
                [
                    'texto' => 'Profissionais de confiança. Entrega rápida, comunicação clara e o resultado superou todas as expectativas.',
                    'nome'  => 'Tiago Rodriguez',
                    'cargo' => 'Diretor · TechFlow Solutions',
                ],
            ] as $testemunho)
            <div class="swiper-slide">
                <div class="max-w-4xl mx-auto px-6 lg:px-16 py-12">
                    <!-- Aspas decorativas -->
                    <span class="block text-6xl font-display text-[var(--accent)]/20 leading-none mb-6">"</span>

                    <!-- Quote -->
                    <blockquote class="text-2xl lg:text-3xl font-display leading-relaxed text-[var(--white)] mb-10">
                        {{ $testemunho['texto'] }}
                    </blockquote>

                    <!-- Author -->
                    <div>
                        <p class="text-base font-medium text-[var(--white)]">{{ $testemunho['nome'] }}</p>
                        <p class="text-sm text-[var(--gray)] mt-1">{{ $testemunho['cargo'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div class="swiper-pagination testimonials-pagination mt-8"></div>
    </div>
</section>
