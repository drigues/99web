<section id="servicos" class="py-32 lg:py-40 relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <x-section-label text="O que fazemos" />

        <h2 class="text-4xl lg:text-6xl font-display leading-tight max-w-3xl" data-animate="fade-up">
            Soluções digitais para empresas que querem <em class="text-[var(--accent-light)]">crescer</em>
        </h2>

        <!-- Serviços como lista expandível — estilo Awwwards accordion -->
        <div class="mt-20 border-t border-white/10" x-data="{ active: null }">

            @php
            $services = [
                [
                    'num' => '01',
                    'title' => 'Websites Profissionais',
                    'desc' => 'Design moderno, responsivo, otimizado para Google. O seu negócio merece estar online com um website que converte visitantes em clientes.',
                    'features' => ['SEO otimizado', 'Mobile-first', 'Entrega 7-14 dias', 'Domínio + Alojamento incluído'],
                    'image_query' => 'modern website design mockup',
                ],
                [
                    'num' => '02',
                    'title' => 'Sistemas Corporativos',
                    'desc' => 'Automatize processos, controle dados, aumente eficiência. Sistemas à medida que transformam a gestão do seu negócio.',
                    'features' => ['Dashboards personalizados', 'Integrações API', 'Painéis admin', 'Relatórios automáticos'],
                    'image_query' => 'business dashboard analytics',
                ],
                [
                    'num' => '03',
                    'title' => 'Google Maps & SEO Local',
                    'desc' => 'Coloque o seu negócio visível nas pesquisas locais. Otimização do perfil Google Business para máxima visibilidade na região.',
                    'features' => ['Perfil Google otimizado', 'Reviews management', 'SEO local', 'Integração Maps'],
                    'image_query' => 'google maps business',
                ],
            ];
            @endphp

            @foreach($services as $i => $service)
            <div class="border-b border-white/10 group"
                 @mouseenter="active = {{ $i }}" @mouseleave="active = null">
                <div class="py-8 lg:py-12 flex items-center justify-between cursor-pointer gap-8"
                     @click="active = active === {{ $i }} ? null : {{ $i }}">

                    <div class="flex items-center gap-6 lg:gap-12 flex-1">
                        <span class="text-sm text-[var(--gray)] font-mono">{{ $service['num'] }}</span>
                        <h3 class="text-2xl lg:text-4xl xl:text-5xl font-display transition-colors duration-300"
                            :class="active === {{ $i }} ? 'text-[var(--accent-light)]' : 'text-[var(--white)]'">
                            {{ $service['title'] }}
                        </h3>
                    </div>

                    <!-- Arrow icon -->
                    <div class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center transition-all duration-300"
                         :class="active === {{ $i }} ? 'bg-[var(--accent)] border-[var(--accent)] rotate-45' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                    </div>
                </div>

                <!-- Expanded content -->
                <div x-show="active === {{ $i }}" x-collapse x-cloak
                     class="pb-8 lg:pb-12">
                    <div class="grid lg:grid-cols-2 gap-8 lg:gap-16 pl-0 lg:pl-20">
                        <div>
                            <p class="text-[var(--gray)] text-lg leading-relaxed">{{ $service['desc'] }}</p>
                            <div class="flex flex-wrap gap-3 mt-6">
                                @foreach($service['features'] as $feat)
                                <span class="text-xs px-3 py-1.5 rounded-full border border-white/10 text-[var(--gray)]">{{ $feat }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="aspect-video rounded-xl bg-[var(--bg-card)] border border-white/5 overflow-hidden" data-img-reveal>
                            <!-- Placeholder visual -->
                            <div class="w-full h-full bg-gradient-to-br from-[var(--accent)]/10 to-transparent flex items-center justify-center">
                                <span class="text-6xl opacity-20">{{ $service['num'] }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
