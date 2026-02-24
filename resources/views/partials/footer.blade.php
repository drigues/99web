<footer role="contentinfo" class="bg-[#0A0612] border-t border-zinc-800/60">

    <div class="max-w-7xl mx-auto px-6 py-14">

        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16">

            {{-- ── Col 1: Marca + info legal ── --}}
            <div>
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="inline-flex items-baseline gap-0.5 mb-5" aria-label="99web — Página inicial">
                    <span class="text-2xl font-bold text-white tracking-tight">99</span><span class="text-2xl font-bold text-brand-accent tracking-tight">web</span>
                </a>

                <p class="text-sm text-zinc-500 leading-relaxed mb-6 max-w-xs">
                    Agência digital especializada em websites, sistemas corporativos e visibilidade no Google.
                </p>

                {{-- Info legal --}}
                <address class="not-italic space-y-1.5 text-xs text-zinc-600">
                    <p>99web, Lda. · NIF 000 000 000</p>
                    <p>Av. da Liberdade, 110</p>
                    <p>1250-096 Lisboa, Portugal</p>
                </address>
            </div>

            {{-- ── Col 2: Serviços ── --}}
            <div>
                <h3 class="text-xs font-bold text-white tracking-widest uppercase mb-5">Serviços</h3>
                <ul class="space-y-3">
                    @foreach ([
                        ['label' => 'Criação de Websites',      'href' => '#servicos'],
                        ['label' => 'Design de Interfaces',     'href' => '#servicos'],
                        ['label' => 'Sistemas Corporativos',    'href' => '#servicos'],
                        ['label' => 'Google Maps',              'href' => '#servicos'],
                    ] as $link)
                        <li>
                            <a
                                href="{{ $link['href'] }}"
                                class="text-sm text-zinc-500 hover:text-violet-400 transition-colors duration-200"
                            >
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- ── Col 3: Contacto ── --}}
            <div>
                <h3 class="text-xs font-bold text-white tracking-widest uppercase mb-5">Contacto</h3>
                <ul class="space-y-4">

                    {{-- Email --}}
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-7 h-7 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Email</p>
                            <a href="mailto:geral@99web.pt" class="text-sm text-zinc-400 hover:text-violet-400 transition-colors duration-200">
                                geral@99web.pt
                            </a>
                        </div>
                    </li>

                    {{-- Telefone --}}
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-7 h-7 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Telefone</p>
                            <a href="tel:+351210000000" class="text-sm text-zinc-400 hover:text-violet-400 transition-colors duration-200">
                                +351 210 000 000
                            </a>
                        </div>
                    </li>

                    {{-- Horário --}}
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-7 h-7 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Horário</p>
                            <p class="text-sm text-zinc-400">Seg – Sex: 09:00 – 18:00</p>
                        </div>
                    </li>

                    {{-- Localização --}}
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 w-7 h-7 rounded-lg bg-violet-500/10 border border-violet-500/20 flex items-center justify-center flex-shrink-0">
                            <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Localização</p>
                            <p class="text-sm text-zinc-400">Lisboa, Portugal</p>
                        </div>
                    </li>

                </ul>
            </div>

        </div>

    </div>

    {{-- Divider + Copyright --}}
    <div class="border-t border-zinc-800/60">
        <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-zinc-600">
                © {{ date('Y') }} 99web. Todos os direitos reservados.
            </p>
            <div class="flex items-center gap-1.5 text-xs text-zinc-700">
                <span>Feito com</span>
                <svg class="w-3 h-3 text-violet-600" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <span>em Portugal</span>
            </div>
        </div>
    </div>

</footer>
