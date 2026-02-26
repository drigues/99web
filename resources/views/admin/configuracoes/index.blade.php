@extends('admin.layouts.admin')

@section('title', 'Configurações')

@section('breadcrumb', 'Configurações')

@section('content')

<div
    x-data="{
        tab: 'geral',
        saving: false,

        async save(tabName) {
            this.saving = true;
            const form = document.getElementById('settings-form-' + tabName);
            const data = new FormData(form);
            data.append('tab', tabName);

            try {
                const res = await fetch('{{ route('admin.configuracoes.update') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: data,
                });
                const json = await res.json();
                if (json.ok) {
                    window.toast(json.message ?? 'Configurações guardadas!', 'success');
                } else {
                    window.toast('Erro ao guardar configurações.', 'error');
                }
            } catch (e) {
                window.toast('Erro de rede. Tente novamente.', 'error');
            } finally {
                this.saving = false;
            }
        }
    }"
    class="space-y-5"
>

    {{-- Header --}}
    <div>
        <h1 class="text-xl font-bold text-white">Configurações</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Gerir todas as definições do site</p>
    </div>

    {{-- Tab nav --}}
    <div class="flex items-center gap-1 border-b border-zinc-800/60 overflow-x-auto pb-0 scrollbar-hide">
        @foreach([
            'geral'       => 'Geral',
            'redes'       => 'Redes Sociais',
            'seo'         => 'SEO',
            'email'       => 'Email',
            'pacotes'     => 'Pacotes',
        ] as $key => $label)
            <button
                type="button"
                @click="tab = '{{ $key }}'"
                :class="tab === '{{ $key }}'
                    ? 'border-b-2 border-violet-500 text-white'
                    : 'text-zinc-500 hover:text-zinc-300 border-b-2 border-transparent'"
                class="flex-shrink-0 px-4 py-3 text-sm font-medium transition-colors"
            >{{ $label }}</button>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB: GERAL
    ══════════════════════════════════════════════════ --}}
    <div x-show="tab === 'geral'" x-cloak>
        <form id="settings-form-geral" @submit.prevent="save('geral')" class="space-y-5">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Nome do site --}}
                <div class="md:col-span-2 bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5">
                    <h3 class="text-sm font-semibold text-white mb-4">Identidade</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Nome do site</label>
                            <input type="text" name="site_name"
                                value="{{ $settings->get('site_name', '99web') }}"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Email geral</label>
                            <input type="email" name="site_email"
                                value="{{ $settings->get('site_email', 'geral@99web.pt') }}"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Telefone</label>
                            <input type="text" name="site_phone"
                                value="{{ $settings->get('site_phone', '') }}"
                                placeholder="+351 939 341 853"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Horário de funcionamento</label>
                            <input type="text" name="site_hours"
                                value="{{ $settings->get('site_hours', 'Seg–Sex, 9h–18h') }}"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">Morada</label>
                            <textarea name="site_address" rows="2"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none">{{ $settings->get('site_address', '') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Logo --}}
                <div class="md:col-span-2 bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5">
                    <h3 class="text-sm font-semibold text-white mb-4">Logo</h3>
                    <div class="flex items-center gap-4 flex-wrap">
                        @if($settings->get('site_logo'))
                            <img src="{{ $settings->get('site_logo') }}" alt="Logo" class="h-10 rounded-lg border border-zinc-700 bg-zinc-800 p-1">
                        @endif
                        <div class="flex-1 min-w-[200px]">
                            <label class="block text-xs font-medium text-zinc-400 mb-1.5">URL do logo (PNG/SVG)</label>
                            <input type="text" name="site_logo"
                                value="{{ $settings->get('site_logo', '') }}"
                                placeholder="https://... ou /storage/site/logo.png"
                                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        </div>
                    </div>
                </div>

            </div>

            <div class="flex justify-end">
                <button type="submit"
                    :disabled="saving"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all
                           disabled:opacity-50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    <span x-text="saving ? 'A guardar…' : 'Guardar alterações'"></span>
                </button>
            </div>

        </form>
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB: REDES SOCIAIS
    ══════════════════════════════════════════════════ --}}
    <div x-show="tab === 'redes'" x-cloak>
        <form id="settings-form-redes" @submit.prevent="save('redes')">

            <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5 space-y-4 mb-5">
                <h3 class="text-sm font-semibold text-white mb-2">Redes Sociais</h3>

                @foreach([
                    'social_facebook'  => ['label' => 'Facebook',   'placeholder' => 'https://facebook.com/99web'],
                    'social_instagram' => ['label' => 'Instagram',   'placeholder' => 'https://instagram.com/99web'],
                    'social_linkedin'  => ['label' => 'LinkedIn',    'placeholder' => 'https://linkedin.com/company/99web'],
                    'social_twitter'   => ['label' => 'Twitter / X', 'placeholder' => 'https://x.com/99web'],
                    'social_youtube'   => ['label' => 'YouTube',     'placeholder' => 'https://youtube.com/@99web'],
                ] as $key => $meta)
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">{{ $meta['label'] }}</label>
                        <input type="url" name="{{ $key }}"
                            value="{{ $settings->get($key, '') }}"
                            placeholder="{{ $meta['placeholder'] }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all disabled:opacity-50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    <span x-text="saving ? 'A guardar…' : 'Guardar alterações'"></span>
                </button>
            </div>

        </form>
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB: SEO
    ══════════════════════════════════════════════════ --}}
    <div x-show="tab === 'seo'" x-cloak>
        <form id="settings-form-seo" @submit.prevent="save('seo')" class="space-y-5">

            <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5 space-y-4">
                <h3 class="text-sm font-semibold text-white mb-2">Meta Tags — Homepage</h3>

                <div x-data="{ title: '{{ addslashes($settings->get('seo_title', '')) }}', desc: '{{ addslashes($settings->get('seo_description', '')) }}' }">
                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-medium text-zinc-400">Meta Título</label>
                            <span class="text-[10px]" :class="title.length > 60 ? 'text-red-400' : 'text-zinc-500'">
                                <span x-text="title.length"></span>/60
                            </span>
                        </div>
                        <input type="text" name="seo_title" x-model="title"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
                            placeholder="99web — Agência Digital | Websites, SEO e Marketing">
                    </div>

                    <div class="mb-4">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-xs font-medium text-zinc-400">Meta Descrição</label>
                            <span class="text-[10px]" :class="desc.length > 160 ? 'text-red-400' : 'text-zinc-500'">
                                <span x-text="desc.length"></span>/160
                            </span>
                        </div>
                        <textarea name="seo_description" rows="3" x-model="desc"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none"
                            placeholder="Criamos websites profissionais…"></textarea>
                    </div>

                    {{-- Google Preview --}}
                    <div class="rounded-xl border border-zinc-700 bg-white/[0.02] p-4">
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-3">Pré-visualização Google</p>
                        <p class="text-xs text-emerald-600">99web.pt</p>
                        <p class="text-sm font-medium text-blue-400 leading-tight mt-0.5" x-text="title || '(sem título)'"></p>
                        <p class="text-xs text-zinc-400 mt-1 leading-relaxed" x-text="desc || '(sem descrição)'"></p>
                    </div>
                </div>
            </div>

            <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5 space-y-4">
                <h3 class="text-sm font-semibold text-white mb-2">Integrações</h3>

                @foreach([
                    'seo_google_analytics'      => ['label' => 'Google Analytics ID (GA4)', 'placeholder' => 'G-XXXXXXXXXX'],
                    'seo_google_search_console' => ['label' => 'Google Search Console Verification', 'placeholder' => 'meta content value'],
                    'seo_facebook_pixel'        => ['label' => 'Facebook Pixel ID', 'placeholder' => '000000000000000'],
                ] as $key => $meta)
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">{{ $meta['label'] }}</label>
                        <input type="text" name="{{ $key }}"
                            value="{{ $settings->get($key, '') }}"
                            placeholder="{{ $meta['placeholder'] }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                @endforeach
            </div>

            <div class="flex justify-end">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all disabled:opacity-50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    <span x-text="saving ? 'A guardar…' : 'Guardar alterações'"></span>
                </button>
            </div>

        </form>
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB: EMAIL
    ══════════════════════════════════════════════════ --}}
    <div x-show="tab === 'email'" x-cloak>
        <form id="settings-form-email" @submit.prevent="save('email')" class="space-y-5">

            <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5 space-y-4">
                <h3 class="text-sm font-semibold text-white mb-2">Configurações de Email</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Email de notificações</label>
                        <input type="email" name="email_notifications"
                            value="{{ $settings->get('email_notifications', 'geral@99web.pt') }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Nome remetente</label>
                        <input type="text" name="email_sender_name"
                            value="{{ $settings->get('email_sender_name', '99web') }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Texto do email de confirmação de contacto</label>
                    <p class="text-[11px] text-zinc-600 mb-1.5">Variáveis: {nome}, {email}</p>
                    <textarea name="email_contact_confirmation" rows="4"
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none font-mono text-xs">{{ $settings->get('email_contact_confirmation', 'Olá {nome}, recebemos a sua mensagem e entraremos em contacto brevemente.') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Texto do email de confirmação de reunião</label>
                    <p class="text-[11px] text-zinc-600 mb-1.5">Variáveis: {nome}, {data}, {hora}</p>
                    <textarea name="email_meeting_confirmation" rows="4"
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none font-mono text-xs">{{ $settings->get('email_meeting_confirmation', 'Olá {nome}, a sua reunião está confirmada para {data} às {hora}.') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all disabled:opacity-50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    <span x-text="saving ? 'A guardar…' : 'Guardar alterações'"></span>
                </button>
            </div>

        </form>
    </div>

    {{-- ══════════════════════════════════════════════════
         TAB: PACOTES
    ══════════════════════════════════════════════════ --}}
    <div x-show="tab === 'pacotes'" x-cloak>
        <form id="settings-form-pacotes" @submit.prevent="save('pacotes')" class="space-y-5">

            @foreach($packages as $slug => $pkg)
            @php
                $activeKey   = "package_{$slug}_active";
                $priceKey    = "package_{$slug}_price";
                $featuresKey = "package_{$slug}_features";

                $isActive    = $settings->get($activeKey, true);
                $price       = $settings->get($priceKey, $pkg['price']);
                $featuresRaw = $settings->get($featuresKey, null);
                $features    = is_array($featuresRaw) ? $featuresRaw : $pkg['features'];
                $featuresText= implode("\n", $features);
            @endphp

            <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5"
                 x-data="{ active: {{ $isActive ? 'true' : 'false' }} }">

                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-sm font-semibold text-white">{{ $pkg['name'] }}</h3>
                        <span class="text-xs text-zinc-500">{{ ucfirst($slug) }}</span>
                    </div>
                    {{-- Toggle ativo/inativo --}}
                    <label class="flex items-center gap-2.5 cursor-pointer select-none">
                        <span class="text-xs font-medium" :class="active ? 'text-emerald-400' : 'text-zinc-500'"
                              x-text="active ? 'Ativo' : 'Inativo'"></span>
                        <div class="relative">
                            <input type="hidden" name="{{ $activeKey }}" :value="active ? '1' : '0'">
                            <div class="w-9 h-5 rounded-full transition-colors duration-200 cursor-pointer"
                                 :class="active ? 'bg-emerald-500' : 'bg-zinc-700'"
                                 @click="active = !active">
                                <div class="absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform duration-200"
                                     :class="active ? 'translate-x-4' : ''"></div>
                            </div>
                        </div>
                    </label>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">Preço</label>
                        <input type="text" name="{{ $priceKey }}"
                            value="{{ $price }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
                            placeholder="399€">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-zinc-400 mb-1.5">
                            Features
                            <span class="text-zinc-600 font-normal">(uma por linha)</span>
                        </label>
                        <textarea name="{{ $featuresKey }}" rows="5"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none font-mono text-xs">{{ $featuresText }}</textarea>
                    </div>
                </div>

            </div>
            @endforeach

            <div class="flex justify-end">
                <button type="submit" :disabled="saving"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all disabled:opacity-50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    <span x-text="saving ? 'A guardar…' : 'Guardar alterações'"></span>
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
