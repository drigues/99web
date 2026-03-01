<section class="py-32 lg:py-40 relative overflow-hidden"
         style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 40%, #5B21B6 100%);">

    <!-- Dot grid decoration -->
    <div class="absolute inset-0 pointer-events-none opacity-[0.06]"
         style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 32px 32px;"
         aria-hidden="true"></div>

    <!-- Glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full blur-3xl pointer-events-none"
         style="background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 60%);"
         aria-hidden="true"></div>

    <div class="relative max-w-4xl mx-auto px-6 lg:px-8 text-center">

        <h2 class="text-3xl lg:text-6xl font-display font-black leading-tight mb-6" data-animate="fade-up">
            Pronto para transformar o seu negócio?
        </h2>

        <p class="text-lg lg:text-xl font-medium text-white/70 max-w-2xl mx-auto mb-12" data-animate="fade-up">
            Fale com a 99web e construa uma presença digital que converte visitantes em clientes.
        </p>

        <div data-animate="fade-up">
            <button
                type="button"
                @click="$dispatch('comecar-agora', { source: 'cta_final' })"
                data-magnetic
                class="inline-flex items-center gap-3 px-10 py-5 rounded-full text-lg font-medium
                       bg-[var(--white)] text-[var(--black)] hover:bg-white
                       hover:shadow-xl hover:shadow-white/20
                       transition-all duration-300"
            >
                Vamos conversar
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </button>
        </div>

        <p class="mt-8 text-sm text-white/40" data-animate="fade-in">
            Sem compromisso. Resposta em 24h.
        </p>

    </div>
</section>
