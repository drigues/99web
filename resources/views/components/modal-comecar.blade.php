{{--
    Modal "Começar Agora"
    - Ativado por evento global: $dispatch('comecar-agora', { source: '...' })
    - Campos: nome, email, telefone, empresa, website, mensagem
    - Submit via fetch (sem reload)
    - Estados: idle | loading | success | error
--}}
<div
    x-data="{
        open: false,
        source: '',
        state: 'idle',
        form: {
            nome: '',
            email: '',
            telefone: '',
            empresa: '',
            website: '',
            mensagem: '',
        },
        errorMsg: '',

        openModal(source) {
            this.source = source ?? '';
            this.state = 'idle';
            this.errorMsg = '';
            this.open = true;
            this.$nextTick(() => this.$refs.firstInput?.focus());
        },

        closeModal() {
            this.open = false;
        },

        async submit() {
            this.state = 'loading';
            this.errorMsg = '';

            try {
                const payload = { ...this.form, source: this.source };

                const response = await fetch('/contacto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (response.ok) {
                    this.state = 'success';
                    this.form = { nome: '', email: '', telefone: '', empresa: '', website: '', mensagem: '' };
                } else {
                    this.state = 'error';
                    this.errorMsg = data.message ?? 'Ocorreu um erro. Tente novamente.';
                }
            } catch (e) {
                this.state = 'error';
                this.errorMsg = 'Sem ligação. Verifique a sua internet e tente novamente.';
            }
        }
    }"
    @comecar-agora.window="openModal($event.detail?.source)"
    @keydown.escape.window="open && closeModal()"
    x-cloak
>
    {{-- ── Overlay ── --}}
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click.self="closeModal()"
        class="fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6 overflow-y-auto"
        style="background: rgba(10, 6, 18, 0.85); backdrop-filter: blur(6px);"
        role="dialog"
        aria-modal="true"
        aria-label="Formulário de contacto"
        style="display: none;"
    >
        {{-- ── Painel ── --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative w-full max-w-lg my-auto rounded-2xl border border-violet-500/20 shadow-2xl shadow-black/60"
            style="background: #1A1225;"
        >
            {{-- Glow decorativo --}}
            <div
                class="absolute -top-24 left-1/2 -translate-x-1/2 w-64 h-64 rounded-full blur-3xl pointer-events-none opacity-30"
                style="background: radial-gradient(circle, #7C3AED 0%, transparent 70%);"
                aria-hidden="true"
            ></div>

            {{-- ─── Cabeçalho ─── --}}
            <div class="relative flex items-center justify-between px-6 pt-6 pb-4 border-b border-violet-500/10">
                <div>
                    <p class="text-xs font-semibold text-violet-400 uppercase tracking-widest mb-0.5">99web</p>
                    <h2 class="text-xl font-bold text-white">Vamos começar?</h2>
                </div>
                <button
                    @click="closeModal()"
                    class="flex items-center justify-center w-8 h-8 rounded-lg text-zinc-500 hover:text-white hover:bg-white/5 transition-colors"
                    aria-label="Fechar"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- ─── Corpo ─── --}}
            <div class="relative px-6 py-6">

                {{-- ══ Estado: sucesso ══ --}}
                <div x-show="state === 'success'" x-cloak class="flex flex-col items-center py-6 text-center">
                    <div class="w-16 h-16 rounded-full bg-green-500/15 border border-green-500/30 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Mensagem enviada!</h3>
                    <p class="text-sm text-zinc-400 leading-relaxed max-w-xs">
                        Recebemos o seu contacto e vamos responder em breve. Obrigado pelo interesse na 99web.
                    </p>
                    <button
                        @click="closeModal()"
                        class="mt-6 px-6 py-2.5 rounded-full text-sm font-semibold text-white transition-all hover:scale-105"
                        style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                    >
                        Fechar
                    </button>
                </div>

                {{-- ══ Estado: formulário ══ --}}
                <form
                    x-show="state !== 'success'"
                    @submit.prevent="submit()"
                    novalidate
                >

                    {{-- Erro global --}}
                    <div
                        x-show="state === 'error' && errorMsg"
                        x-cloak
                        class="mb-4 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/25 text-sm text-red-400"
                        role="alert"
                        x-text="errorMsg"
                    ></div>

                    <div class="space-y-4">

                        {{-- Nome --}}
                        <div>
                            <label for="modal-nome" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                Nome <span class="text-violet-400">*</span>
                            </label>
                            <input
                                id="modal-nome"
                                type="text"
                                x-model="form.nome"
                                x-ref="firstInput"
                                placeholder="O seu nome completo"
                                required
                                autocomplete="name"
                                class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                       transition-colors duration-200"
                            >
                        </div>

                        {{-- Email --}}
                        <div>
                            <label for="modal-email" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                Email <span class="text-violet-400">*</span>
                            </label>
                            <input
                                id="modal-email"
                                type="email"
                                x-model="form.email"
                                placeholder="email@empresa.pt"
                                required
                                autocomplete="email"
                                class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                       transition-colors duration-200"
                            >
                        </div>

                        {{-- Telefone + Empresa (grid 2 cols) --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="modal-telefone" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                    Telefone
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-zinc-500 pointer-events-none select-none">+351</span>
                                    <input
                                        id="modal-telefone"
                                        type="tel"
                                        x-model="form.telefone"
                                        placeholder="912 345 678"
                                        autocomplete="tel"
                                        class="w-full pl-11 pr-3 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                               placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                               transition-colors duration-200"
                                    >
                                </div>
                            </div>

                            <div>
                                <label for="modal-empresa" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                    Empresa
                                </label>
                                <input
                                    id="modal-empresa"
                                    type="text"
                                    x-model="form.empresa"
                                    placeholder="Nome da empresa"
                                    autocomplete="organization"
                                    class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                           placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                           transition-colors duration-200"
                                >
                            </div>
                        </div>

                        {{-- Website --}}
                        <div>
                            <label for="modal-website" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                Website atual (se tiver)
                            </label>
                            <input
                                id="modal-website"
                                type="url"
                                x-model="form.website"
                                placeholder="https://www.exemplo.pt"
                                autocomplete="url"
                                class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                       transition-colors duration-200"
                            >
                        </div>

                        {{-- Mensagem --}}
                        <div>
                            <label for="modal-mensagem" class="block text-xs font-medium text-zinc-400 mb-1.5">
                                Como posso ajudar? <span class="text-violet-400">*</span>
                            </label>
                            <textarea
                                id="modal-mensagem"
                                x-model="form.mensagem"
                                rows="3"
                                placeholder="Descreva brevemente o seu projeto ou necessidade…"
                                required
                                class="w-full px-4 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white text-sm
                                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                       transition-colors duration-200 resize-none"
                            ></textarea>
                        </div>

                    </div>

                    {{-- Rodapé do form --}}
                    <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">

                        <p class="text-xs text-zinc-600 order-2 sm:order-1">
                            Sem spam. Resposta em 24 h úteis.
                        </p>

                        <button
                            type="submit"
                            :disabled="state === 'loading'"
                            class="order-1 sm:order-2 w-full sm:w-auto inline-flex items-center justify-center gap-2
                                   px-7 py-3 rounded-full text-sm font-bold text-white
                                   disabled:opacity-60 disabled:cursor-not-allowed
                                   transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-violet-500/30"
                            style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                        >
                            {{-- Spinner loading --}}
                            <svg
                                x-show="state === 'loading'"
                                class="animate-spin w-4 h-4"
                                fill="none" viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>

                            <span x-text="state === 'loading' ? 'A enviar…' : 'Enviar mensagem'"></span>
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</div>
