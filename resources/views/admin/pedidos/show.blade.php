@extends('admin.layouts.admin')

@section('title', 'Pedido — ' . $pedido->name)
@section('breadcrumb', 'Pedido #' . $pedido->id)

@section('content')

@php
$packageColors = [
    'essencial'     => 'bg-blue-500/15 text-blue-300 border-blue-500/20',
    'corporativo'   => 'bg-violet-500/15 text-violet-300 border-violet-500/20',
    'personalizado' => 'bg-amber-500/15 text-amber-300 border-amber-500/20',
];
@endphp

<div class="space-y-5">

    {{-- Nav --}}
    <div class="flex items-center gap-3">
        <a
            href="{{ route('admin.pedidos.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-violet-400 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Pedidos
        </a>
        <span class="text-zinc-700">/</span>
        <span class="text-sm text-white">#{{ $pedido->id }} — {{ $pedido->name }}</span>
    </div>

    <div class="grid lg:grid-cols-[1fr_300px] gap-5 items-start">

        {{-- ── Coluna principal ── --}}
        <div class="space-y-5">

            {{-- Resumo do pacote --}}
            @if($package)
            <x-admin.card title="Pacote solicitado">
                <div class="p-5">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <span class="inline-flex items-center text-[11px] font-bold px-2.5 py-1 rounded-full border
                                         {{ $packageColors[$pedido->package_type] ?? 'bg-zinc-700 text-zinc-300 border-zinc-600' }}">
                                {{ $package['badge'] ?? $pedido->package_type }}
                            </span>
                            <h3 class="text-base font-bold text-white mt-2">{{ $package['name'] }}</h3>
                            <p class="text-sm text-zinc-400 mt-1">{{ $package['description'] }}</p>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-xl font-bold text-white">{{ $package['price'] }}</p>
                            <p class="text-xs text-zinc-500">{{ $package['price_note'] }}</p>
                        </div>
                    </div>
                    @if(!empty($package['features']))
                    <div class="border-t border-zinc-800/60 pt-4">
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2.5">Incluído</p>
                        <ul class="space-y-1.5">
                            @foreach($package['features'] as $feature)
                            <li class="flex items-center gap-2 text-sm text-zinc-300">
                                <svg class="w-3.5 h-3.5 text-violet-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $feature }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </x-admin.card>
            @endif

            {{-- Dados do cliente --}}
            <x-admin.card title="Dados do cliente">
                <div class="p-6 grid sm:grid-cols-2 gap-5">

                    @foreach([
                        'Nome'    => $pedido->name,
                        'Email'   => $pedido->email,
                        'Telefone'=> $pedido->phone ?? '—',
                        'Empresa' => $pedido->company ?? '—',
                    ] as $label => $value)
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">{{ $label }}</p>
                            @if($label === 'Email')
                                <a href="mailto:{{ $value }}" class="text-sm text-violet-400 hover:text-violet-300 transition-colors">{{ $value }}</a>
                            @else
                                <p class="text-sm text-white">{{ $value }}</p>
                            @endif
                        </div>
                    @endforeach

                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Recebido</p>
                        <p class="text-sm text-white">{{ $pedido->created_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>

                </div>
            </x-admin.card>

            {{-- Detalhes do projeto --}}
            <x-admin.card title="Detalhes do projeto">
                <div class="p-6 space-y-5">

                    <div class="grid sm:grid-cols-2 gap-5">

                        {{-- Domínio --}}
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Tem domínio?</p>
                            <p class="text-sm {{ $pedido->has_domain ? 'text-emerald-400' : 'text-zinc-400' }}">
                                {{ $pedido->has_domain ? 'Sim' : 'Não' }}
                            </p>
                        </div>

                        {{-- Alojamento --}}
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Tem alojamento?</p>
                            <p class="text-sm {{ $pedido->has_hosting ? 'text-emerald-400' : 'text-zinc-400' }}">
                                {{ $pedido->has_hosting ? 'Sim' : 'Não' }}
                            </p>
                        </div>

                        {{-- Site atual --}}
                        @if($pedido->current_website)
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Site atual</p>
                            <a href="{{ $pedido->current_website }}" target="_blank"
                               class="text-sm text-violet-400 hover:text-violet-300 transition-colors break-all">
                                {{ $pedido->current_website }}
                            </a>
                        </div>
                        @endif

                        {{-- Prazo --}}
                        @if($pedido->deadline)
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Prazo pretendido</p>
                            <p class="text-sm text-white">{{ $pedido->deadline->format('d/m/Y') }}</p>
                        </div>
                        @endif

                        {{-- Orçamento --}}
                        @if($pedido->budget)
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Orçamento</p>
                            <p class="text-sm text-white">{{ $pedido->budget }}</p>
                        </div>
                        @endif

                    </div>

                    {{-- Descrição do projeto --}}
                    @if($pedido->project_description)
                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-2">Descrição do projeto</p>
                        <p class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $pedido->project_description }}</p>
                    </div>
                    @endif

                </div>
            </x-admin.card>

            {{-- Notas internas (AJAX) --}}
            <x-admin.card title="Notas internas">
                <div
                    class="p-6"
                    x-data="{
                        notes: @js($pedido->notes ?? ''),
                        saving: false,
                        saved: false,
                        async save() {
                            this.saving = true;
                            const r = await fetch('{{ route('admin.pedidos.updateNotes', $pedido) }}', {
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                                },
                                body: JSON.stringify({ notes: this.notes })
                            });
                            this.saving = false;
                            if (r.ok) { this.saved = true; setTimeout(() => this.saved = false, 2500); }
                        }
                    }"
                >
                    <textarea
                        x-model="notes"
                        rows="5"
                        placeholder="Notas internas sobre este pedido…"
                        class="w-full px-4 py-3 rounded-xl bg-white/5 border border-zinc-700 text-sm text-white
                               placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none mb-3"
                    ></textarea>
                    <div class="flex items-center justify-between gap-3">
                        <p class="text-xs text-zinc-600">Visível apenas para a equipa admin.</p>
                        <button
                            @click="save()"
                            :disabled="saving"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold text-white
                                   disabled:opacity-60 transition-all"
                            style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                        >
                            <svg x-show="saving" class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            <svg x-show="saved" x-cloak class="w-3.5 h-3.5 text-emerald-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="saving ? 'A guardar…' : (saved ? 'Guardado!' : 'Guardar notas')"></span>
                        </button>
                    </div>
                </div>
            </x-admin.card>

        </div>

        {{-- ── Sidebar de ações ── --}}
        <div class="space-y-4">

            {{-- Status atual --}}
            <x-admin.card title="Estado">
                <div class="p-5 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-zinc-500">Estado atual</span>
                        <x-admin.status-badge :status="$pedido->status" type="package"/>
                    </div>

                    {{-- Alterar status --}}
                    <form method="POST" action="{{ route('admin.pedidos.updateStatus', $pedido) }}">
                        @csrf @method('PATCH')
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Alterar para</label>
                        <select
                            name="status"
                            class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                                   focus:outline-none focus:border-violet-500/60 transition-colors appearance-none mb-3"
                        >
                            @foreach(['novo' => 'Novo', 'contactado' => 'Contactado', 'proposta_enviada' => 'Proposta Enviada', 'aprovado' => 'Aprovado', 'recusado' => 'Recusado'] as $val => $label)
                                <option value="{{ $val }}" @selected($pedido->status === $val)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <button
                            type="submit"
                            class="w-full py-2 rounded-lg text-sm font-semibold text-white transition-all"
                            style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
                        >
                            Atualizar estado
                        </button>
                    </form>
                </div>
            </x-admin.card>

            {{-- Ações rápidas --}}
            <x-admin.card title="Ações">
                <div class="p-4 space-y-2">

                    <a
                        href="mailto:{{ $pedido->email }}?subject=Re: Pedido de pacote {{ $package['name'] ?? '' }} — 99web"
                        class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-medium
                               text-zinc-300 border border-zinc-700 hover:border-violet-500/40 hover:text-violet-400
                               hover:bg-violet-500/5 transition-all"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        Responder por email
                    </a>

                    @if($pedido->phone)
                        <a
                            href="tel:{{ $pedido->phone }}"
                            class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-medium
                                   text-zinc-300 border border-zinc-700 hover:border-emerald-500/40 hover:text-emerald-400
                                   hover:bg-emerald-500/5 transition-all"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            Ligar {{ $pedido->phone }}
                        </a>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('admin.pedidos.destroy', $pedido) }}"
                        x-data
                        @submit.prevent="if(confirm('Eliminar este pedido permanentemente?')) $el.submit()"
                    >
                        @csrf @method('DELETE')
                        <button
                            type="submit"
                            class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-medium
                                   text-red-400 border border-red-500/20 hover:border-red-500/40 hover:bg-red-500/10 transition-all"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                            Eliminar pedido
                        </button>
                    </form>

                </div>
            </x-admin.card>

            {{-- Info do registo --}}
            <x-admin.card>
                <div class="p-4 space-y-2.5 text-xs text-zinc-500">
                    <div class="flex justify-between">
                        <span>ID</span>
                        <span class="text-zinc-300">#{{ $pedido->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Pacote</span>
                        <span class="text-zinc-300 capitalize">{{ $pedido->package_type }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Criado</span>
                        <span class="text-zinc-300">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($pedido->updated_at && $pedido->updated_at != $pedido->created_at)
                        <div class="flex justify-between">
                            <span>Atualizado</span>
                            <span class="text-zinc-300">{{ $pedido->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </x-admin.card>

        </div>

    </div>

</div>

@endsection
