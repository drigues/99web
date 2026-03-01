<footer role="contentinfo" class="border-t border-[var(--border-subtle)]">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">

        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16">

            {{-- Col 1: Marca --}}
            <div>
                <a href="/" class="inline-block text-3xl font-extrabold mb-5" style="font-family: var(--font-body);">
                    <span class="text-[var(--accent)]">99</span>web
                </a>

                <p class="text-base text-[var(--gray)] leading-relaxed mb-6 max-w-xs">
                    Agência digital especializada em websites, sistemas corporativos e visibilidade no Google.
                </p>

                <address class="not-italic text-xs text-[var(--gray)]">
                    {{ $settings->get('site_name', '99web') }} · {{ $settings->get('contact_address', 'Óbidos, Portugal') }}
                </address>
            </div>

            {{-- Col 2: Serviços --}}
            <div>
                <h3 class="text-xs font-medium text-[var(--white)] tracking-widest uppercase mb-5">Serviços</h3>
                <ul class="space-y-3">
                    @foreach ([
                        'Criação de Websites',
                        'Design de Interfaces',
                        'Sistemas Corporativos',
                        'Google Maps',
                    ] as $label)
                        <li>
                            <a href="#servicos" class="text-base font-medium text-[var(--gray)] hover:text-[var(--white)] transition-colors duration-300">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Col 3: Contacto --}}
            <div>
                <h3 class="text-xs font-medium text-[var(--white)] tracking-widest uppercase mb-5">Contacto</h3>
                <ul class="space-y-4">
                    <li>
                        <p class="text-[10px] text-[var(--gray)] uppercase tracking-wider mb-0.5">Telefone</p>
                        <a href="tel:{{ preg_replace('/\s+/', '', $settings->get('contact_phone', '+351939341853')) }}" class="text-base text-[var(--white)] hover:text-[var(--accent)] transition-colors duration-300">
                            {{ $settings->get('contact_phone', '+351 939 341 853') }}
                        </a>
                    </li>
                    <li>
                        <p class="text-[10px] text-[var(--gray)] uppercase tracking-wider mb-0.5">Horário</p>
                        <p class="text-base text-[var(--white)]">{{ $settings->get('working_hours', 'Seg – Sex: 09:00 – 18:00') }}</p>
                    </li>
                    <li>
                        <p class="text-[10px] text-[var(--gray)] uppercase tracking-wider mb-0.5">Localização</p>
                        <p class="text-base text-[var(--white)]">{{ $settings->get('contact_address', 'Óbidos, Portugal') }}</p>
                    </li>
                </ul>

                <button
                    type="button"
                    @click="$dispatch('comecar-agora', { source: 'cta_footer' })"
                    data-magnetic
                    class="mt-6 inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-medium text-white
                           bg-[var(--accent)] hover:bg-[var(--accent-light)] transition-colors duration-300"
                >
                    Começar Agora
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </button>
            </div>

        </div>

    </div>

    {{-- Copyright --}}
    <div class="border-t border-[var(--border-subtle)]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-[var(--gray)]">
                © {{ date('Y') }} 99web. Todos os direitos reservados.
            </p>
            <div class="flex items-center gap-1.5 text-xs text-[var(--gray)]">
                <span>Feito com</span>
                <svg class="w-3 h-3 text-[var(--accent)]" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                </svg>
                <span>em Portugal</span>
            </div>
        </div>
    </div>

</footer>
