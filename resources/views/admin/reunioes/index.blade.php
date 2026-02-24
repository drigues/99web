@extends('admin.layouts.admin')

@section('title', 'Reuniões')
@section('breadcrumb', 'Reuniões')

@section('content')

<div class="space-y-5">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Reuniões</h1>
            <p class="text-sm text-zinc-500 mt-0.5">{{ $reunioes->total() }} registos no total</p>
        </div>
    </div>

    {{-- Filtros --}}
    <x-admin.filter-bar :action="route('admin.reunioes.index')">

        {{-- Busca --}}
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Pesquisa</label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nome ou email…"
                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
            >
        </div>

        {{-- Status --}}
        <div class="min-w-[140px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Estado</label>
            <select
                name="status"
                class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                       focus:outline-none focus:border-violet-500/60 transition-colors appearance-none"
            >
                <option value="">Todos</option>
                @foreach(['pendente' => 'Pendente', 'confirmado' => 'Confirmado', 'cancelado' => 'Cancelado'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Formato --}}
        <div class="min-w-[130px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Formato</label>
            <select
                name="meeting_type"
                class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                       focus:outline-none focus:border-violet-500/60 transition-colors appearance-none"
            >
                <option value="">Todos</option>
                <option value="online" @selected(request('meeting_type') === 'online')>Online</option>
                <option value="presencial" @selected(request('meeting_type') === 'presencial')>Presencial</option>
            </select>
        </div>

        {{-- A partir de --}}
        <div class="min-w-[150px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">A partir de</label>
            <input
                type="date"
                name="date_from"
                value="{{ request('date_from') }}"
                class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                       focus:outline-none focus:border-violet-500/60 transition-colors"
            >
        </div>

    </x-admin.filter-bar>

    {{-- Tabela --}}
    <x-admin.table>

        <x-slot:header>
            <span class="text-sm font-semibold text-white">Resultados</span>
            <span class="text-xs text-zinc-500">{{ $reunioes->count() }} nesta página</span>
        </x-slot:header>

        <thead>
            <tr class="border-b border-white/5">
                <th class="text-left px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Cliente</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden md:table-cell">Data preferida</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden lg:table-cell">Formato</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Estado</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden sm:table-cell">Enviado</th>
                <th class="px-4 py-3 text-right text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/[0.04]">
            @forelse($reunioes as $reuniao)
            @php
                $dateStr = $reuniao->preferred_date?->toDateString();
                $isToday    = $dateStr === $today;
                $isTomorrow = $dateStr === $tomorrow;
            @endphp
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-6 py-4">
                    <div class="font-medium text-white">{{ $reuniao->name }}</div>
                    <div class="text-xs text-zinc-500 mt-0.5">{{ $reuniao->email }}</div>
                    @if($reuniao->company)
                        <div class="text-xs text-zinc-600 mt-0.5">{{ $reuniao->company }}</div>
                    @endif
                </td>
                <td class="px-4 py-4 hidden md:table-cell">
                    @if($reuniao->preferred_date)
                        <div class="text-sm {{ $isToday ? 'text-amber-400 font-semibold' : ($isTomorrow ? 'text-violet-400' : 'text-zinc-300') }}">
                            @if($isToday)
                                <span class="text-[10px] font-bold bg-amber-500/15 text-amber-300 px-1.5 py-0.5 rounded mr-1">Hoje</span>
                            @elseif($isTomorrow)
                                <span class="text-[10px] font-bold bg-violet-500/15 text-violet-300 px-1.5 py-0.5 rounded mr-1">Amanhã</span>
                            @endif
                            {{ $reuniao->preferred_date->format('d/m/Y') }}
                        </div>
                        @if($reuniao->preferred_time)
                            <div class="text-xs text-zinc-500 mt-0.5">{{ $reuniao->preferred_time }}</div>
                        @endif
                    @else
                        <span class="text-sm text-zinc-600">—</span>
                    @endif
                </td>
                <td class="px-4 py-4 hidden lg:table-cell">
                    @if($reuniao->meeting_type)
                        <span class="text-[11px] font-medium px-2 py-0.5 rounded
                                     {{ $reuniao->meeting_type === 'online' ? 'bg-blue-500/15 text-blue-300' : 'bg-zinc-700 text-zinc-300' }}">
                            {{ ucfirst($reuniao->meeting_type) }}
                        </span>
                    @else
                        <span class="text-sm text-zinc-600">—</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <x-admin.status-badge :status="$reuniao->status" type="meeting"/>
                </td>
                <td class="px-4 py-4 hidden sm:table-cell">
                    <span class="text-xs text-zinc-500" title="{{ $reuniao->created_at->format('d/m/Y H:i') }}">
                        {{ $reuniao->created_at->diffForHumans() }}
                    </span>
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center justify-end gap-2">

                        {{-- Ver --}}
                        <a
                            href="{{ route('admin.reunioes.show', $reuniao) }}"
                            class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500
                                   hover:text-violet-400 hover:bg-violet-500/10 transition-colors"
                            title="Ver detalhes"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </a>

                        {{-- Eliminar --}}
                        <form
                            method="POST"
                            action="{{ route('admin.reunioes.destroy', $reuniao) }}"
                            x-data
                            @submit.prevent="if(confirm('Eliminar esta reunião?')) $el.submit()"
                        >
                            @csrf @method('DELETE')
                            <button
                                type="submit"
                                class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-600
                                       hover:text-red-400 hover:bg-red-500/10 transition-colors"
                                title="Eliminar"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                                </svg>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-14 text-center text-sm text-zinc-500">
                    Nenhuma reunião encontrada.
                </td>
            </tr>
            @endforelse
        </tbody>

        <x-slot:footer>
            <x-admin.pagination :items="$reunioes"/>
        </x-slot:footer>

    </x-admin.table>

</div>

@endsection
