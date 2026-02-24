{{--
    Partial: partials/portfolio-card
    Variáveis esperadas:
      $projeto   = ['nome' => string, 'tipo' => string, 'gradiente' => string (CSS gradient)]
      $categoria = 'websites' | 'sistemas'
--}}
<article
    class="group rounded-2xl border border-violet-500/15 bg-[#14102A] overflow-hidden
           cursor-pointer transition-all duration-300
           hover:border-violet-500/50 hover:scale-[1.02]
           hover:shadow-xl hover:shadow-violet-950/60"
>
    {{-- Área de imagem placeholder --}}
    <div
        class="relative h-44 overflow-hidden"
        style="background: {{ $projeto['gradiente'] }};"
        aria-hidden="true"
    >
        {{-- Grade decorativa sutil --}}
        <div
            class="absolute inset-0 opacity-[0.06]"
            style="background-image:
                linear-gradient(rgba(255,255,255,0.6) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.6) 1px, transparent 1px);
                background-size: 20px 20px;"
        ></div>

        {{-- Glow central --}}
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2
                    w-28 h-28 rounded-full blur-2xl bg-violet-600/25
                    group-hover:bg-violet-500/40 transition-colors duration-300">
        </div>

        {{-- Ícone central --}}
        <div class="absolute inset-0 flex flex-col items-center justify-center gap-3">

            <div class="w-12 h-12 rounded-2xl bg-white/10 border border-white/15
                        flex items-center justify-center
                        group-hover:bg-violet-500/20 group-hover:border-violet-500/40
                        transition-all duration-300">

                @if ($categoria === 'websites')
                    {{-- Ícone globo --}}
                    <svg class="w-5 h-5 text-violet-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>
                    </svg>
                @else
                    {{-- Ícone dashboard / tabela --}}
                    <svg class="w-5 h-5 text-violet-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/>
                    </svg>
                @endif
            </div>

        </div>

        {{-- Overlay gradiente base → card (para fade suave no fundo) --}}
        <div class="absolute bottom-0 inset-x-0 h-12 bg-gradient-to-t from-[#14102A] to-transparent"></div>

        {{-- Seta "ver projeto" aparece no hover --}}
        <div class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/10 border border-white/15
                    flex items-center justify-center
                    opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0
                    transition-all duration-300">
            <svg class="w-3.5 h-3.5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25"/>
            </svg>
        </div>
    </div>

    {{-- Informações do projeto --}}
    <div class="px-4 py-3.5">
        <h3 class="text-sm font-semibold text-white mb-1 group-hover:text-violet-200 transition-colors duration-200">
            {{ $projeto['nome'] }}
        </h3>
        <span class="inline-flex items-center gap-1.5 text-[11px] font-medium text-violet-400/80">
            <span class="w-1 h-1 rounded-full bg-violet-500/60 inline-block"></span>
            {{ $projeto['tipo'] }}
        </span>
    </div>
</article>
