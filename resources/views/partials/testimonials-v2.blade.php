<section class="py-32 lg:py-48 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 mb-20">

        <x-section-label text="Testemunhos" />

        <h2 class="text-3xl lg:text-6xl font-display font-black leading-tight max-w-3xl" data-animate="fade-up">
            O que dizem os nossos clientes
        </h2>

    </div>

    @php
    $testimonials = [
        ['texto' => 'Foi a melhor decisão que tomei para o meu negócio. O site ficou incrível e os clientes aumentaram significativamente.', 'nome' => 'João Santos', 'cargo' => 'CEO · Restaurante Mar Aberto'],
        ['texto' => 'Trabalho de excelente qualidade e atenção ao detalhe. Recomendo a toda a gente que precise de presença online.', 'nome' => 'Ana Costa', 'cargo' => 'Fundadora · Studio AC Design'],
        ['texto' => 'Profissionais de confiança. Entrega rápida, comunicação clara e o resultado superou todas as expectativas.', 'nome' => 'Tiago Rodriguez', 'cargo' => 'Diretor · TechFlow Solutions'],
        ['texto' => 'O nosso tráfego orgânico triplicou em três meses. O investimento em SEO e design valeu cada cêntimo.', 'nome' => 'Marta Lopes', 'cargo' => 'Marketing · Granber Industrial'],
        ['texto' => 'Design moderno, rápido e intuitivo. Os nossos clientes elogiam constantemente o novo website.', 'nome' => 'Pedro Almeida', 'cargo' => 'Sócio-Gerente · Navego Travel'],
        ['texto' => 'Suporte impecável mesmo após a entrega. Sentem-se como parceiros, não apenas fornecedores.', 'nome' => 'Sofia Mendes', 'cargo' => 'Diretora · Clínica Vitalmed'],
        ['texto' => 'Em duas semanas tínhamos um website profissional, responsivo e otimizado. Impressionante.', 'nome' => 'Ricardo Ferreira', 'cargo' => 'Fundador · RF Consulting'],
        ['texto' => 'A integração com Google Maps trouxe-nos dezenas de novos clientes locais. Transformou o negócio.', 'nome' => 'Carla Nunes', 'cargo' => 'Proprietária · Padaria Artesanal'],
    ];
    $row1 = array_slice($testimonials, 0, 4);
    $row2 = array_slice($testimonials, 4, 4);
    @endphp

    {{-- Row 1 — scrolls left --}}
    <div class="marquee-left overflow-hidden mb-6" data-animate="fade-in">
        <div class="marquee-track">
            @foreach(array_merge($row1, $row1) as $t)
            <div class="flex-shrink-0 w-[380px] lg:w-[480px] mr-6 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-8">
                <span class="block text-4xl font-display text-[var(--accent)]/20 leading-none mb-4" aria-hidden="true">&ldquo;</span>
                <blockquote class="text-base lg:text-lg font-medium leading-relaxed text-[var(--white)] mb-6">
                    {{ $t['texto'] }}
                </blockquote>
                <div>
                    <p class="text-base font-bold text-[var(--white)]">{{ $t['nome'] }}</p>
                    <p class="text-sm text-[var(--gray)] mt-1">{{ $t['cargo'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Row 2 — scrolls right --}}
    <div class="marquee-right overflow-hidden" data-animate="fade-in">
        <div class="marquee-track">
            @foreach(array_merge($row2, $row2) as $t)
            <div class="flex-shrink-0 w-[380px] lg:w-[480px] mr-6 bg-[var(--bg-card)] border border-[var(--border-color)] rounded-2xl p-8">
                <span class="block text-4xl font-display text-[var(--accent)]/20 leading-none mb-4" aria-hidden="true">&ldquo;</span>
                <blockquote class="text-base lg:text-lg font-medium leading-relaxed text-[var(--white)] mb-6">
                    {{ $t['texto'] }}
                </blockquote>
                <div>
                    <p class="text-base font-bold text-[var(--white)]">{{ $t['nome'] }}</p>
                    <p class="text-sm text-[var(--gray)] mt-1">{{ $t['cargo'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
