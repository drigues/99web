@extends('admin.layouts.admin')

@section('title', 'Reunião — ' . $reuniao->name)
@section('breadcrumb', 'Reunião #' . $reuniao->id)

@section('content')

<div class="space-y-5">

    {{-- Nav --}}
    <div class="flex items-center gap-3">
        <a
            href="{{ route('admin.reunioes.index') }}"
            class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-violet-400 transition-colors"
        >
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Reuniões
        </a>
        <span class="text-zinc-700">/</span>
        <span class="text-sm text-white">#{{ $reuniao->id }} — {{ $reuniao->name }}</span>
    </div>

    <div class="grid lg:grid-cols-[1fr_300px] gap-5 items-start">

        {{-- ── Coluna principal ── --}}
        <div class="space-y-5">

            {{-- Dados do cliente --}}
            <x-admin.card title="Dados do cliente">
                <div class="p-6 grid sm:grid-cols-2 gap-5">

                    @foreach([
                        'Nome'    => $reuniao->name,
                        'Email'   => $reuniao->email,
                        'Telefone'=> $reuniao->phone ?? '—',
                        'Empresa' => $reuniao->company ?? '—',
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

                    @if($reuniao->current_website)
                        <div>
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Site atual</p>
                            <a href="{{ $reuniao->current_website }}" target="_blank"
                               class="text-sm text-violet-400 hover:text-violet-300 transition-colors break-all">
                                {{ $reuniao->current_website }}
                            </a>
                        </div>
                    @endif

                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Recebido</p>
                        <p class="text-sm text-white">{{ $reuniao->created_at->format('d/m/Y \à\s H:i') }}</p>
                    </div>

                </div>
            </x-admin.card>

            {{-- Detalhes da reunião --}}
            <x-admin.card title="Preferências de reunião">
                <div class="p-6 grid sm:grid-cols-2 gap-5">

                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Data preferida</p>
                        <p class="text-sm text-white">
                            {{ $reuniao->preferred_date ? $reuniao->preferred_date->format('d/m/Y') : '—' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Hora preferida</p>
                        <p class="text-sm text-white">{{ $reuniao->preferred_time ?? '—' }}</p>
                    </div>

                    <div>
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Formato</p>
                        <p class="text-sm text-white capitalize">{{ $reuniao->meeting_type ?? '—' }}</p>
                    </div>

                    @if($reuniao->status === 'confirmado' && $reuniao->confirmed_date)
                        <div class="sm:col-span-2">
                            <p class="text-[10px] font-bold text-emerald-500/80 uppercase tracking-wider mb-1">✓ Data confirmada</p>
                            <p class="text-sm text-emerald-400 font-semibold">
                                {{ $reuniao->confirmed_date->format('d/m/Y') }}
                                @if($reuniao->confirmed_time)
                                    às {{ $reuniao->confirmed_time }}
                                @endif
                            </p>
                        </div>
                    @endif

                </div>
            </x-admin.card>

            {{-- Objetivos --}}
            @if($reuniao->objectives)
            <x-admin.card title="Objetivos / Mensagem">
                <div class="p-6">
                    <p class="text-sm text-zinc-300 leading-relaxed whitespace-pre-wrap">{{ $reuniao->objectives }}</p>
                </div>
            </x-admin.card>
            @endif

            {{-- Notas internas (AJAX) --}}
            <x-admin.card title="Notas internas">
                <div
                    class="p-6"
                    x-data="{
                        notes: @js($reuniao->admin_notes ?? ''),
                        saving: false,
                        saved: false,
                        async save() {
                            this.saving = true;
                            const r = await fetch('{{ route('admin.reunioes.updateNotes', $reuniao) }}', {
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
                        placeholder="Notas internas sobre esta reunião…"
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
                        <x-admin.status-badge :status="$reuniao->status" type="meeting"/>
                    </div>

                    {{-- Alterar status --}}
                    <form method="POST" action="{{ route('admin.reunioes.updateStatus', $reuniao) }}">
                        @csrf @method('PATCH')
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Alterar para</label>
                        <select
                            name="status"
                            class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                                   focus:outline-none focus:border-violet-500/60 transition-colors appearance-none mb-3"
                        >
                            @foreach(['pendente' => 'Pendente', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado'] as $val => $label)
                                <option value="{{ $val }}" @selected($reuniao->status === $val)>{{ $label }}</option>
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

            {{-- Confirmar Reunião --}}
            @if($reuniao->status !== 'cancelado')
            <x-admin.card title="Confirmar Reunião">
                <div class="p-5">
                    <p class="text-xs text-zinc-500 mb-4">Define a data e hora confirmadas e envia email ao cliente.</p>
                    <form method="POST" action="{{ route('admin.reunioes.confirm', $reuniao) }}">
                        @csrf

                        <div class="space-y-3 mb-4">
                            <div>
                                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">
                                    Data confirmada
                                </label>
                                <input
                                    type="date"
                                    name="confirmed_date"
                                    value="{{ $reuniao->confirmed_date?->format('Y-m-d') ?? $reuniao->preferred_date?->format('Y-m-d') }}"
                                    min="{{ now()->format('Y-m-d') }}"
                                    class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                                           focus:outline-none focus:border-violet-500/60 transition-colors"
                                    required
                                >
                                @error('confirmed_date')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">
                                    Hora confirmada
                                </label>
                                <input
                                    type="time"
                                    name="confirmed_time"
                                    value="{{ $reuniao->confirmed_time ?? $reuniao->preferred_time }}"
                                    class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                                           focus:outline-none focus:border-violet-500/60 transition-colors"
                                    required
                                >
                                @error('confirmed_time')
                                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="w-full py-2.5 rounded-lg text-sm font-semibold text-white transition-all
                                   flex items-center justify-center gap-2"
                            style="background: linear-gradient(135deg, #059669 0%, #047857 100%);"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirmar e enviar email
                        </button>
                    </form>
                </div>
            </x-admin.card>
            @endif

            {{-- Ações rápidas --}}
            <x-admin.card title="Ações">
                <div class="p-4 space-y-2">

                    <a
                        href="mailto:{{ $reuniao->email }}?subject=Re: Pedido de reunião — 99web"
                        class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-medium
                               text-zinc-300 border border-zinc-700 hover:border-violet-500/40 hover:text-violet-400
                               hover:bg-violet-500/5 transition-all"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                        Responder por email
                    </a>

                    @if($reuniao->phone)
                        <a
                            href="tel:{{ $reuniao->phone }}"
                            class="flex items-center gap-2.5 w-full px-4 py-2.5 rounded-lg text-sm font-medium
                                   text-zinc-300 border border-zinc-700 hover:border-emerald-500/40 hover:text-emerald-400
                                   hover:bg-emerald-500/5 transition-all"
                        >
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                            </svg>
                            Ligar {{ $reuniao->phone }}
                        </a>
                    @endif

                    <form
                        method="POST"
                        action="{{ route('admin.reunioes.destroy', $reuniao) }}"
                        x-data
                        @submit.prevent="if(confirm('Eliminar esta reunião permanentemente?')) $el.submit()"
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
                            Eliminar reunião
                        </button>
                    </form>

                </div>
            </x-admin.card>

            {{-- Info do registo --}}
            <x-admin.card>
                <div class="p-4 space-y-2.5 text-xs text-zinc-500">
                    <div class="flex justify-between">
                        <span>ID</span>
                        <span class="text-zinc-300">#{{ $reuniao->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Formato</span>
                        <span class="text-zinc-300 capitalize">{{ $reuniao->meeting_type ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Criado</span>
                        <span class="text-zinc-300">{{ $reuniao->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($reuniao->updated_at && $reuniao->updated_at != $reuniao->created_at)
                        <div class="flex justify-between">
                            <span>Atualizado</span>
                            <span class="text-zinc-300">{{ $reuniao->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    @endif
                </div>
            </x-admin.card>

        </div>

    </div>

</div>

@endsection
