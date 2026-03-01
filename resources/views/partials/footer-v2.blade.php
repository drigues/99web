<footer role="contentinfo" class="border-t border-[var(--border-subtle)]">

    <div class="max-w-7xl mx-auto px-6 lg:px-8 py-16">

        <div class="grid lg:grid-cols-3 gap-12 lg:gap-16">

            {{-- Col 1: Marca --}}
            <div>
                <a href="/" class="inline-block text-3xl font-extrabold mb-5" style="font-family: var(--font-body);">
                    <span class="text-[var(--accent)]">99</span>web
                </a>

                <p class="text-base text-[var(--gray)] leading-relaxed mb-6 max-w-xs">
                    {{ $settings->get('footer_tagline', 'Agência digital especializada em websites, sistemas corporativos e visibilidade no Google.') }}
                </p>

                <address class="not-italic text-xs text-[var(--gray)]">
                    {{ $settings->get('site_name', '99web') }} · {{ $settings->get('contact_address', 'Óbidos, Portugal') }}
                </address>

                {{-- Redes sociais --}}
                @php
                    $socials = [
                        ['key' => 'social_instagram', 'icon' => '<path d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2Zm0 1.5A4.25 4.25 0 0 0 3.5 7.75v8.5A4.25 4.25 0 0 0 7.75 20.5h8.5A4.25 4.25 0 0 0 20.5 16.25v-8.5A4.25 4.25 0 0 0 16.25 3.5Zm4.25 3.25a5.25 5.25 0 1 1 0 10.5 5.25 5.25 0 0 1 0-10.5Zm0 1.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5Zm5.5-1.5a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"/>'],
                        ['key' => 'social_linkedin', 'icon' => '<path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 0 1-2.063-2.065 2.064 2.064 0 1 1 2.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>'],
                        ['key' => 'social_github', 'icon' => '<path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>'],
                        ['key' => 'social_facebook', 'icon' => '<path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>'],
                        ['key' => 'social_twitter', 'icon' => '<path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>'],
                        ['key' => 'social_youtube', 'icon' => '<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814z"/>'],
                    ];
                @endphp
                <div class="flex items-center gap-3 mt-5">
                    @foreach ($socials as $social)
                        @if ($settings->get($social['key']))
                            <a href="{{ $settings->get($social['key']) }}" target="_blank" rel="noopener noreferrer"
                               class="w-8 h-8 rounded-full bg-white/5 border border-[var(--border-color)] flex items-center justify-center
                                      text-[var(--gray)] hover:text-[var(--accent)] hover:border-[var(--accent)]/40 transition-all duration-300">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">{!! $social['icon'] !!}</svg>
                            </a>
                        @endif
                    @endforeach
                </div>
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
                {{ $settings->get('copyright_text', '© ' . date('Y') . ' 99web. Todos os direitos reservados.') }}
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
