<section id="faq" class="py-32 lg:py-40">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">

        <x-section-label text="Dúvidas" />

        <h2 class="text-3xl lg:text-6xl font-display font-black leading-tight mb-20" data-animate="fade-up">
            Perguntas frequentes
        </h2>

        @php
        $faqs = [
            [
                'pergunta' => 'Preciso de ter conhecimentos técnicos para gerir o meu site?',
                'resposta' => 'Não. Todos os nossos sites são entregues com um painel de gestão simples e intuitivo. Formamos a sua equipa numa sessão de onboarding e ficamos disponíveis sempre que precisar de ajuda.',
            ],
            [
                'pergunta' => 'O domínio e o alojamento estão incluídos?',
                'resposta' => 'No primeiro ano, o domínio e o alojamento premium estão incluídos no preço do pacote. A partir do segundo ano, a renovação é cobrada separadamente — geralmente entre 80€ e 150€/ano, dependendo do plano.',
            ],
            [
                'pergunta' => 'Qual é o prazo de entrega de um website?',
                'resposta' => 'Um website standard fica pronto em 7 a 14 dias úteis após recebermos todos os conteúdos (textos, imagens, logótipo). Projetos mais complexos, como lojas online ou sistemas, têm prazos acordados no briefing.',
            ],
            [
                'pergunta' => 'Posso fazer alterações ao site depois de entregue?',
                'resposta' => 'Sim. Nos primeiros 30 dias estão incluídas revisões ilimitadas sem custo. Após esse período, pode contratar o nosso plano de manutenção mensal ou pedir alterações pontuais mediante orçamento.',
            ],
            [
                'pergunta' => 'O que acontece ao fim de 12 meses?',
                'resposta' => 'O site continua a ser seu para sempre. A subscrição anual cobre o alojamento, atualizações de segurança e suporte prioritário. Pode cancelar a qualquer momento e migrar o site para outro servidor.',
            ],
            [
                'pergunta' => 'Posso acompanhar as estatísticas do meu site?',
                'resposta' => 'Sim. Integramos o Google Analytics 4 e/ou o Google Search Console em todos os projetos. Pode ver em tempo real quantas pessoas visitam o seu site, de onde vêm e quais as páginas mais populares.',
            ],
        ];
        @endphp

        <div x-data="{ open: null }" class="border-t border-[var(--border-color)]" data-animate="fade-up">
            @foreach ($faqs as $index => $faq)
            <div class="border-b border-[var(--border-color)]">
                <button
                    type="button"
                    class="w-full flex items-center gap-6 lg:gap-10 py-7 lg:py-8 text-left group focus:outline-none"
                    x-on:click="open = open === {{ $index }} ? null : {{ $index }}"
                    :aria-expanded="open === {{ $index }}"
                >
                    <!-- Number -->
                    <span class="text-sm text-[var(--gray)] font-mono flex-shrink-0">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>

                    <!-- Question -->
                    <span class="flex-1 text-xl lg:text-2xl font-display font-bold text-[var(--white)] group-hover:text-[var(--accent-light)] transition-colors duration-300">
                        {{ $faq['pergunta'] }}
                    </span>

                    <!-- Plus/Cross icon -->
                    <span class="w-8 h-8 flex items-center justify-center flex-shrink-0 text-[var(--gray)] transition-transform duration-300"
                          :class="open === {{ $index }} ? 'rotate-45' : ''">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                            <path stroke-linecap="round" d="M12 5v14M5 12h14"/>
                        </svg>
                    </span>
                </button>

                <!-- Answer -->
                <div x-show="open === {{ $index }}" x-collapse x-cloak>
                    <div class="pb-8 pl-0 lg:pl-16 pr-14">
                        <p class="text-[var(--gray)] text-base lg:text-lg font-medium leading-relaxed max-w-2xl">
                            {{ $faq['resposta'] }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
