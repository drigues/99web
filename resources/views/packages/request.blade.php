@extends('layouts.app')

@section('title', 'Pedido — ' . $package['name'] . ' · 99web')
@section('description', 'Preencha os dados para solicitar o pacote ' . $package['name'] . ' da 99web.')

@section('content')

<div
    class="min-h-screen pt-24 pb-16 relative overflow-hidden"
    style="background: #0F0A1A;"
    x-data="{
        step: 1,
        maxSteps: 3,
        type: '{{ $type }}',

        {{-- Step 1 --}}
        nome: '',
        email: '',
        telefone: '',
        empresa: '',

        {{-- Step 2 --}}
        descricao: '',
        tem_dominio: false,
        tem_alojamento: false,
        website_atual: '',
        prazo: '',
        orcamento: '',

        {{-- Step 3 --}}
        aceita_termos: false,
        aceita_comunicacoes: false,

        errors: {},

        validateStep1() {
            this.errors = {};
            let valid = true;
            if (!this.nome.trim() || this.nome.trim().length < 2) {
                this.errors.nome = 'O nome é obrigatório (mínimo 2 caracteres).';
                valid = false;
            }
            if (!this.email.trim() || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                this.errors.email = 'Introduza um email válido.';
                valid = false;
            }
            if (!this.telefone.trim()) {
                this.errors.telefone = 'O telefone é obrigatório.';
                valid = false;
            }
            if (!this.empresa.trim()) {
                this.errors.empresa = 'A empresa é obrigatória.';
                valid = false;
            }
            return valid;
        },

        validateStep2() {
            this.errors = {};
            let valid = true;
            if (!this.descricao.trim() || this.descricao.trim().length < 10) {
                this.errors.descricao = 'A descrição deve ter pelo menos 10 caracteres.';
                valid = false;
            }
            if (!this.prazo) {
                this.errors.prazo = 'Selecione um prazo desejado.';
                valid = false;
            }
            if (this.type === 'personalizado' && !this.orcamento) {
                this.errors.orcamento = 'Indique o orçamento estimado.';
                valid = false;
            }
            return valid;
        },

        validateStep3() {
            this.errors = {};
            if (!this.aceita_termos) {
                this.errors.aceita_termos = 'Deve aceitar os Termos e Condições para continuar.';
                return false;
            }
            return true;
        },

        nextStep() {
            if (this.step === 1 && !this.validateStep1()) return;
            if (this.step === 2 && !this.validateStep2()) return;
            this.step++;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        prevStep() {
            if (this.step > 1) this.step--;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        prazoLabel(val) {
            const map = {
                '1_semana': '1 semana',
                '2_semanas': '2 semanas',
                '1_mes': '1 mês',
                'sem_urgencia': 'Sem urgência',
            };
            return map[val] || '—';
        }
    }"
>

    {{-- Glow de fundo --}}
    <div
        class="absolute top-0 inset-x-0 h-[500px] pointer-events-none"
        style="background: radial-gradient(ellipse 70% 45% at 50% -10%, rgba(124,58,237,0.22) 0%, transparent 70%);"
        aria-hidden="true"
    ></div>

    <div class="relative max-w-5xl mx-auto px-6">

        {{-- ── Breadcrumb / back ── --}}
        <div class="mb-8">
            <a
                href="{{ route('home') }}#pacotes"
                class="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-violet-400 transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar aos pacotes
            </a>
        </div>

        {{-- ── Header da página ── --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-violet-500/30 bg-violet-500/10 mb-4">
                <span class="text-xs font-semibold text-violet-400 tracking-widest uppercase">Pedido de Pacote</span>
            </div>
            <h1 class="text-3xl font-bold text-white">{{ $package['name'] }}</h1>
            <p class="text-zinc-400 mt-2 max-w-sm mx-auto text-sm">{{ $package['description'] }}</p>
        </div>

        {{-- ── Progress bar ── --}}
        <div class="max-w-xl mx-auto mb-10">
            {{-- Passos --}}
            <div class="flex items-center gap-0 mb-3">
                @foreach([1 => 'Sobre si', 2 => 'Sobre o projeto', 3 => 'Confirmação'] as $n => $label)
                    {{-- Círculo de passo --}}
                    <div class="flex flex-col items-center">
                        <div
                            class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300"
                            :class="step >= {{ $n }}
                                ? 'text-white'
                                : 'bg-white/5 border border-white/10 text-zinc-500'"
                            :style="step >= {{ $n }} ? 'background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);' : ''"
                        >
                            <span x-show="step > {{ $n }}" aria-hidden="true">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </span>
                            <span x-show="step <= {{ $n }}">{{ $n }}</span>
                        </div>
                        <span
                            class="text-[10px] mt-1 font-medium transition-colors duration-300 hidden sm:block"
                            :class="step >= {{ $n }} ? 'text-violet-400' : 'text-zinc-600'"
                        >{{ $label }}</span>
                    </div>

                    @if($n < 3)
                        {{-- Linha conectora --}}
                        <div class="flex-1 h-px mx-2 relative overflow-hidden rounded-full bg-white/10">
                            <div
                                class="absolute inset-y-0 left-0 transition-all duration-500"
                                :style="step > {{ $n }} ? 'width:100%; background: linear-gradient(to right, #7C3AED, #6D28D9);' : 'width:0;'"
                            ></div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- ── Layout grid: formulário + card pacote ── --}}
        <div class="grid lg:grid-cols-[1fr_300px] gap-8 items-start">

            {{-- ══════════════════════════════════════
                 FORMULÁRIO PRINCIPAL
            ══════════════════════════════════════ --}}
            <div>
                <form
                    method="POST"
                    action="{{ route('pacotes.store', $type) }}"
                    x-on:submit.prevent="if (validateStep3()) $el.submit()"
                >
                    @csrf

                    {{-- Campos ocultos (alimentados por Alpine) --}}
                    <input type="hidden" name="nome"           :value="nome">
                    <input type="hidden" name="email"          :value="email">
                    <input type="hidden" name="telefone"       :value="telefone">
                    <input type="hidden" name="empresa"        :value="empresa">
                    <input type="hidden" name="descricao"      :value="descricao">
                    <input type="hidden" name="tem_dominio"    :value="tem_dominio ? '1' : '0'">
                    <input type="hidden" name="tem_alojamento" :value="tem_alojamento ? '1' : '0'">
                    <input type="hidden" name="website_atual"  :value="website_atual">
                    <input type="hidden" name="prazo"          :value="prazo">
                    <input type="hidden" name="orcamento"      :value="orcamento">
                    <input type="hidden" name="aceita_termos"  :value="aceita_termos ? '1' : '0'">
                    <input type="hidden" name="aceita_comunicacoes" :value="aceita_comunicacoes ? '1' : '0'">

                    {{-- Erros do servidor (se houver redirect de volta) --}}
                    @if($errors->any())
                        <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/25 text-sm text-red-400">
                            <p class="font-semibold mb-1">Por favor corrija os seguintes erros:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div
                        class="rounded-2xl border border-violet-500/15 p-8"
                        style="background: #1A1225;"
                    >

                        {{-- ══ STEP 1: Sobre si ══ --}}
                        <div x-show="step === 1" x-cloak>

                            <h2 class="text-lg font-bold text-white mb-1">Sobre si</h2>
                            <p class="text-sm text-zinc-500 mb-6">Dados de contacto para acompanhar o seu pedido.</p>

                            <div class="space-y-5">

                                {{-- Nome --}}
                                <div>
                                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                        Nome completo <span class="text-violet-400">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        x-model="nome"
                                        placeholder="O seu nome completo"
                                        autocomplete="name"
                                        class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                               placeholder-zinc-600 focus:outline-none focus:bg-white/8
                                               transition-colors duration-200"
                                        :class="errors.nome ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                    >
                                    <p x-show="errors.nome" x-text="errors.nome" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                </div>

                                {{-- Email --}}
                                <div>
                                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                        Email <span class="text-violet-400">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        x-model="email"
                                        placeholder="email@empresa.pt"
                                        autocomplete="email"
                                        class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                               placeholder-zinc-600 focus:outline-none focus:bg-white/8
                                               transition-colors duration-200"
                                        :class="errors.email ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                    >
                                    <p x-show="errors.email" x-text="errors.email" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                </div>

                                {{-- Telefone + Empresa --}}
                                <div class="grid sm:grid-cols-2 gap-5">
                                    <div>
                                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                            Telefone <span class="text-violet-400">*</span>
                                        </label>
                                        <input
                                            type="tel"
                                            x-model="telefone"
                                            placeholder="+351 912 345 678"
                                            autocomplete="tel"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                                   placeholder-zinc-600 focus:outline-none focus:bg-white/8
                                                   transition-colors duration-200"
                                            :class="errors.telefone ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                        >
                                        <p x-show="errors.telefone" x-text="errors.telefone" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                            Empresa <span class="text-violet-400">*</span>
                                        </label>
                                        <input
                                            type="text"
                                            x-model="empresa"
                                            placeholder="Nome da empresa"
                                            autocomplete="organization"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                                   placeholder-zinc-600 focus:outline-none focus:bg-white/8
                                                   transition-colors duration-200"
                                            :class="errors.empresa ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                        >
                                        <p x-show="errors.empresa" x-text="errors.empresa" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                    </div>
                                </div>

                            </div>

                        </div>

                        {{-- ══ STEP 2: Sobre o projeto ══ --}}
                        <div x-show="step === 2" x-cloak>

                            <h2 class="text-lg font-bold text-white mb-1">Sobre o projeto</h2>
                            <p class="text-sm text-zinc-500 mb-6">Ajude-nos a perceber o que precisa.</p>

                            <div class="space-y-5">

                                {{-- Descrição --}}
                                <div>
                                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                        Descreva o seu projeto <span class="text-violet-400">*</span>
                                    </label>
                                    <textarea
                                        x-model="descricao"
                                        rows="4"
                                        placeholder="Que tipo de site precisa? Tem referências? Que objetivos quer atingir?…"
                                        class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                               placeholder-zinc-600 focus:outline-none focus:bg-white/8
                                               transition-colors duration-200 resize-none"
                                        :class="errors.descricao ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                    ></textarea>
                                    <p x-show="errors.descricao" x-text="errors.descricao" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                </div>

                                {{-- Toggles: domínio + alojamento --}}
                                <div class="grid sm:grid-cols-2 gap-4">

                                    {{-- Tem domínio? --}}
                                    <div
                                        class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer select-none"
                                        @click="tem_dominio = !tem_dominio"
                                    >
                                        <div>
                                            <p class="text-sm font-medium text-white">Já tem domínio?</p>
                                            <p class="text-xs text-zinc-500">ex: www.empresa.pt</p>
                                        </div>
                                        <div
                                            class="w-11 h-6 rounded-full relative transition-colors duration-200 flex-shrink-0"
                                            :class="tem_dominio ? 'bg-violet-600' : 'bg-white/10'"
                                        >
                                            <div
                                                class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                                                :class="tem_dominio ? 'translate-x-5' : 'translate-x-0.5'"
                                            ></div>
                                        </div>
                                    </div>

                                    {{-- Tem alojamento? --}}
                                    <div
                                        class="flex items-center justify-between px-4 py-3 rounded-xl border border-white/10 bg-white/5 cursor-pointer select-none"
                                        @click="tem_alojamento = !tem_alojamento"
                                    >
                                        <div>
                                            <p class="text-sm font-medium text-white">Já tem alojamento?</p>
                                            <p class="text-xs text-zinc-500">servidor/hosting ativo</p>
                                        </div>
                                        <div
                                            class="w-11 h-6 rounded-full relative transition-colors duration-200 flex-shrink-0"
                                            :class="tem_alojamento ? 'bg-violet-600' : 'bg-white/10'"
                                        >
                                            <div
                                                class="absolute top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform duration-200"
                                                :class="tem_alojamento ? 'translate-x-5' : 'translate-x-0.5'"
                                            ></div>
                                        </div>
                                    </div>

                                </div>

                                {{-- Website atual --}}
                                <div>
                                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                        Website atual (se tiver)
                                    </label>
                                    <input
                                        type="url"
                                        x-model="website_atual"
                                        placeholder="https://www.empresa.pt"
                                        autocomplete="url"
                                        class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-sm
                                               placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 focus:bg-white/8
                                               transition-colors duration-200"
                                    >
                                </div>

                                {{-- Prazo + Orçamento (se personalizado) --}}
                                <div class="grid sm:grid-cols-2 gap-5">

                                    {{-- Prazo --}}
                                    <div>
                                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                            Prazo desejado <span class="text-violet-400">*</span>
                                        </label>
                                        <select
                                            x-model="prazo"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                                   focus:outline-none focus:bg-white/8 transition-colors duration-200
                                                   appearance-none"
                                            :class="errors.prazo ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                            style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' viewBox='0 0 24 24' stroke='%2371717a' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 16px center;"
                                        >
                                            <option value="" class="bg-[#1A1225]" disabled>Selecione…</option>
                                            <option value="1_semana" class="bg-[#1A1225]">1 semana</option>
                                            <option value="2_semanas" class="bg-[#1A1225]">2 semanas</option>
                                            <option value="1_mes" class="bg-[#1A1225]">1 mês</option>
                                            <option value="sem_urgencia" class="bg-[#1A1225]">Sem urgência</option>
                                        </select>
                                        <p x-show="errors.prazo" x-text="errors.prazo" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                    </div>

                                    {{-- Orçamento (só para personalizado) --}}
                                    <div x-show="type === 'personalizado'">
                                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                                            Orçamento estimado <span class="text-violet-400">*</span>
                                        </label>
                                        <select
                                            x-model="orcamento"
                                            class="w-full px-4 py-3 rounded-xl bg-white/5 border text-white text-sm
                                                   focus:outline-none focus:bg-white/8 transition-colors duration-200
                                                   appearance-none"
                                            :class="errors.orcamento ? 'border-red-500/60' : 'border-white/10 focus:border-violet-500/60'"
                                            style="background-image: url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' viewBox='0 0 24 24' stroke='%2371717a' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;); background-repeat: no-repeat; background-position: right 16px center;"
                                        >
                                            <option value="" class="bg-[#1A1225]" disabled>Selecione…</option>
                                            <option value="Menos de 1.000€" class="bg-[#1A1225]">Menos de 1.000€</option>
                                            <option value="1.000€ – 3.000€" class="bg-[#1A1225]">1.000€ – 3.000€</option>
                                            <option value="3.000€ – 7.500€" class="bg-[#1A1225]">3.000€ – 7.500€</option>
                                            <option value="7.500€ – 15.000€" class="bg-[#1A1225]">7.500€ – 15.000€</option>
                                            <option value="Mais de 15.000€" class="bg-[#1A1225]">Mais de 15.000€</option>
                                            <option value="A definir" class="bg-[#1A1225]">A definir na reunião</option>
                                        </select>
                                        <p x-show="errors.orcamento" x-text="errors.orcamento" class="mt-1.5 text-xs text-red-400" x-cloak></p>
                                    </div>

                                </div>

                            </div>

                        </div>

                        {{-- ══ STEP 3: Confirmação ══ --}}
                        <div x-show="step === 3" x-cloak>

                            <h2 class="text-lg font-bold text-white mb-1">Confirmação</h2>
                            <p class="text-sm text-zinc-500 mb-6">Verifique os seus dados antes de confirmar o pedido.</p>

                            {{-- Resumo Step 1 --}}
                            <div class="rounded-xl border border-white/8 bg-white/3 divide-y divide-white/8 mb-5">

                                <div class="px-4 py-2.5 flex items-center justify-between">
                                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Dados pessoais</span>
                                    <button
                                        type="button"
                                        @click="step = 1"
                                        class="text-xs text-violet-400 hover:text-violet-300 transition-colors"
                                    >Editar</button>
                                </div>

                                <div class="px-4 py-3 grid sm:grid-cols-2 gap-3">
                                    <div>
                                        <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Nome</p>
                                        <p class="text-sm text-white" x-text="nome || '—'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Email</p>
                                        <p class="text-sm text-white break-all" x-text="email || '—'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Telefone</p>
                                        <p class="text-sm text-white" x-text="telefone || '—'"></p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Empresa</p>
                                        <p class="text-sm text-white" x-text="empresa || '—'"></p>
                                    </div>
                                </div>

                            </div>

                            {{-- Resumo Step 2 --}}
                            <div class="rounded-xl border border-white/8 bg-white/3 divide-y divide-white/8 mb-5">

                                <div class="px-4 py-2.5 flex items-center justify-between">
                                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-widest">Sobre o projeto</span>
                                    <button
                                        type="button"
                                        @click="step = 2"
                                        class="text-xs text-violet-400 hover:text-violet-300 transition-colors"
                                    >Editar</button>
                                </div>

                                <div class="px-4 py-3 space-y-3">
                                    <div>
                                        <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Descrição</p>
                                        <p class="text-sm text-zinc-300 leading-relaxed line-clamp-3" x-text="descricao || '—'"></p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Tem domínio</p>
                                            <p class="text-sm text-white" x-text="tem_dominio ? 'Sim' : 'Não'"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Tem alojamento</p>
                                            <p class="text-sm text-white" x-text="tem_alojamento ? 'Sim' : 'Não'"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Prazo</p>
                                            <p class="text-sm text-white" x-text="prazoLabel(prazo)"></p>
                                        </div>
                                        <div x-show="type === 'personalizado' && orcamento">
                                            <p class="text-[10px] text-zinc-600 uppercase tracking-wider mb-0.5">Orçamento</p>
                                            <p class="text-sm text-white" x-text="orcamento"></p>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- Termos e comunicações --}}
                            <div class="space-y-3 mt-6">

                                {{-- Aceitar termos --}}
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <div
                                        class="mt-0.5 w-5 h-5 rounded flex-shrink-0 border-2 flex items-center justify-center transition-all duration-200"
                                        :class="aceita_termos ? 'border-violet-500 bg-violet-500' : (errors.aceita_termos ? 'border-red-500/60' : 'border-white/20')"
                                        @click="aceita_termos = !aceita_termos"
                                    >
                                        <svg x-show="aceita_termos" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-zinc-300">
                                        Li e aceito os
                                        <a href="#" class="text-violet-400 hover:text-violet-300 underline transition-colors">Termos e Condições</a>
                                        e a
                                        <a href="#" class="text-violet-400 hover:text-violet-300 underline transition-colors">Política de Privacidade</a>.
                                        <span class="text-violet-400">*</span>
                                    </span>
                                </label>
                                <p x-show="errors.aceita_termos" x-text="errors.aceita_termos" class="ml-8 text-xs text-red-400" x-cloak></p>

                                {{-- Aceitar comunicações --}}
                                <label class="flex items-start gap-3 cursor-pointer">
                                    <div
                                        class="mt-0.5 w-5 h-5 rounded flex-shrink-0 border-2 flex items-center justify-center transition-all duration-200"
                                        :class="aceita_comunicacoes ? 'border-violet-500 bg-violet-500' : 'border-white/20'"
                                        @click="aceita_comunicacoes = !aceita_comunicacoes"
                                    >
                                        <svg x-show="aceita_comunicacoes" class="w-3 h-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-sm text-zinc-400">
                                        Aceito receber comunicações comerciais da 99web (dicas, novidades e promoções). Pode cancelar a qualquer momento.
                                    </span>
                                </label>

                            </div>

                        </div>

                        {{-- ── Navegação de steps ── --}}
                        <div
                            class="flex items-center justify-between mt-8 pt-6 border-t border-white/8"
                        >

                            {{-- Botão Anterior --}}
                            <button
                                type="button"
                                x-show="step > 1"
                                @click="prevStep()"
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full text-sm font-medium
                                       text-zinc-400 border border-white/10 hover:border-white/20 hover:text-white
                                       transition-all duration-200"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                </svg>
                                Anterior
                            </button>
                            <div x-show="step === 1"></div>

                            {{-- Botão Próximo / Confirmar --}}
                            <button
                                :type="step < 3 ? 'button' : 'submit'"
                                @click="step < 3 && nextStep()"
                                class="inline-flex items-center gap-2 px-7 py-3 rounded-full text-sm font-bold text-white
                                       transition-all duration-200 hover:scale-105 hover:shadow-lg hover:shadow-violet-500/30"
                                style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                            >
                                <span x-text="step < 3 ? 'Próximo' : 'Confirmar Pedido'"></span>
                                <svg x-show="step < 3" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                                <svg x-show="step === 3" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                            </button>

                        </div>

                    </div>

                </form>
            </div>

            {{-- ══════════════════════════════════════
                 CARD LATERAL DO PACOTE
            ══════════════════════════════════════ --}}
            <div class="hidden lg:block">
                <div
                    class="sticky top-24 rounded-2xl border p-6"
                    style="{{ $package['highlight'] ? 'background: linear-gradient(160deg, #1E0F3A 0%, #1A1225 100%); border-color: rgb(124 58 237 / 0.5);' : 'background: #1A1225; border-color: rgb(124 58 237 / 0.2);' }}"
                >

                    {{-- Badge --}}
                    @if($package['highlight'])
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md
                                     bg-violet-500/20 border border-violet-500/40
                                     text-[10px] font-bold text-violet-300 tracking-widest uppercase mb-4">
                            <span class="w-1.5 h-1.5 rounded-full bg-violet-400 animate-ping inline-block"></span>
                            {{ $package['badge'] }}
                        </span>
                    @else
                        <span class="inline-block px-2.5 py-1 rounded-md bg-white/5 border border-white/10
                                     text-[10px] font-bold text-zinc-400 tracking-widest uppercase mb-4">
                            {{ $package['badge'] }}
                        </span>
                    @endif

                    <h3 class="text-lg font-bold text-white mb-1">{{ $package['name'] }}</h3>
                    <p class="text-xs text-zinc-500 mb-4">{{ $package['description'] }}</p>

                    {{-- Preço --}}
                    <div class="mb-5 pb-5 border-b border-white/8">
                        <span class="text-3xl font-bold {{ $package['highlight'] ? 'text-white' : 'text-white' }}">{{ $package['price'] }}</span>
                        <p class="text-xs text-zinc-500 mt-0.5">{{ $package['price_note'] }}</p>
                    </div>

                    {{-- Features --}}
                    <ul class="space-y-2.5">
                        @foreach($package['features'] as $feature)
                            <li class="flex items-start gap-2.5">
                                <div class="mt-0.5 w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0
                                            {{ $package['highlight'] ? 'bg-violet-500/25' : 'bg-violet-500/15' }}">
                                    <svg class="w-2.5 h-2.5 {{ $package['highlight'] ? 'text-violet-300' : 'text-violet-400' }}"
                                         fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-xs {{ $package['highlight'] ? 'text-zinc-200' : 'text-zinc-300' }}">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Garantia --}}
                    <div class="mt-5 pt-4 border-t border-white/8 flex items-center gap-2">
                        <svg class="w-4 h-4 text-violet-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>
                        </svg>
                        <p class="text-xs text-zinc-500">Sem compromisso até aprovação da proposta</p>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>

@endsection
