<section id="projetos" class="py-32 lg:py-40 bg-[var(--bg-card)]/30">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-16">
            <div>
                <x-section-label text="Trabalhos" />
                <h2 class="text-3xl lg:text-6xl font-display font-black" data-animate="fade-up">Projetos selecionados</h2>
            </div>
            <a href="#" class="text-[var(--accent-light)] text-sm flex items-center gap-2 hover:gap-3 transition-all" data-magnetic>
                Ver todos os projetos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <!-- Grid de projetos — layout assimétrico -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8" data-animate="stagger">

            @php
            $projects = [
                ['name' => 'Mesahu', 'type' => 'WebsRest & Reservas', 'color' => 'from-emerald-500/20 to-emerald-900/40', 'size' => 'large'],
                ['name' => 'Granber', 'type' => 'Sistema Corporativo', 'color' => 'from-blue-500/20 to-blue-900/40', 'size' => 'normal'],
                ['name' => 'Navego', 'type' => 'Plataforma Web', 'color' => 'from-orange-500/20 to-orange-900/40', 'size' => 'normal'],
                ['name' => 'Abacate Café', 'type' => 'WebsRest & Reservas', 'color' => 'from-[var(--accent)]/20 to-purple-900/40', 'size' => 'large'],
            ];
            @endphp

            @foreach($projects as $i => $project)
            <a href="#" class="group block {{ $project['size'] === 'large' ? 'lg:col-span-2' : '' }}">
                <div class="relative overflow-hidden rounded-2xl bg-[var(--bg-card)] border border-[var(--border-subtle)]
                            {{ $project['size'] === 'large' ? 'aspect-[21/9]' : 'aspect-[4/3]' }}" data-img-reveal>
                    <!-- Background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br {{ $project['color'] }} transition-transform duration-700 group-hover:scale-105"></div>

                    <!-- Project name overlay -->
                    <div class="absolute inset-0 flex items-center justify-center opacity-10 group-hover:opacity-20 transition-opacity duration-500">
                        <span class="text-[8vw] font-display text-[var(--white)] whitespace-nowrap">{{ $project['name'] }}</span>
                    </div>

                    <!-- Bottom info -->
                    <div class="absolute bottom-0 left-0 right-0 p-6 lg:p-8 bg-gradient-to-t from-black/60 to-transparent">
                        <div class="flex items-end justify-between">
                            <div>
                                <span class="text-sm font-medium text-[var(--gray)] uppercase tracking-wider">{{ $project['type'] }}</span>
                                <h3 class="text-xl lg:text-2xl font-display font-bold mt-1 group-hover:text-[var(--accent-light)] transition-colors">{{ $project['name'] }}</h3>
                            </div>
                            <div class="w-10 h-10 rounded-full border border-[var(--border-color)] flex items-center justify-center group-hover:bg-[var(--accent)] group-hover:border-[var(--accent)] transition-all duration-300 translate-y-2 group-hover:translate-y-0 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-width="1.5" d="M7 17L17 7M17 7H7M17 7v10"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach

        </div>
    </div>
</section>
