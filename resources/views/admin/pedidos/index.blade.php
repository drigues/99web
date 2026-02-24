@extends('admin.layouts.admin')

@section('title', 'Pedidos de Pacotes')
@section('breadcrumb', 'Pedidos de Pacotes')

@section('content')

@php
$packageColors = [
    'essencial'     => 'bg-blue-500/15 text-blue-300',
    'corporativo'   => 'bg-violet-500/15 text-violet-300',
    'personalizado' => 'bg-amber-500/15 text-amber-300',
];
$packageLabels = [
    'essencial'     => 'Essencial',
    'corporativo'   => 'Corporativo',
    'personalizado' => 'Personalizado',
];
@endphp

<div class="space-y-5">

    {{-- Cabeçalho --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Pedidos de Pacotes</h1>
            <p class="text-sm text-zinc-500 mt-0.5">{{ $pedidos->total() }} registos no total</p>
        </div>
    </div>

    {{-- Filtros --}}
    <x-admin.filter-bar :action="route('admin.pedidos.index')">

        {{-- Busca --}}
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Pesquisa</label>
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nome, email ou empresa…"
                class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                       placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
            >
        </div>

        {{-- Pacote --}}
        <div class="min-w-[140px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Pacote</label>
            <select
                name="package_type"
                class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                       focus:outline-none focus:border-violet-500/60 transition-colors appearance-none"
            >
                <option value="">Todos</option>
                @foreach($packages as $slug => $pkg)
                    <option value="{{ $slug }}" @selected(request('package_type') === $slug)>{{ $pkg['name'] }}</option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div class="min-w-[150px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Estado</label>
            <select
                name="status"
                class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                       focus:outline-none focus:border-violet-500/60 transition-colors appearance-none"
            >
                <option value="">Todos</option>
                @foreach(['novo' => 'Novo', 'contactado' => 'Contactado', 'proposta_enviada' => 'Proposta Enviada', 'aprovado' => 'Aprovado', 'recusado' => 'Recusado'] as $val => $label)
                    <option value="{{ $val }}" @selected(request('status') === $val)>{{ $label }}</option>
                @endforeach
            </select>
        </div>

    </x-admin.filter-bar>

    {{-- Tabela --}}
    <x-admin.table>

        <x-slot:header>
            <span class="text-sm font-semibold text-white">Resultados</span>
            <span class="text-xs text-zinc-500">{{ $pedidos->count() }} nesta página</span>
        </x-slot:header>

        <thead>
            <tr class="border-b border-white/5">
                <th class="text-left px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Cliente</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Pacote</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Estado</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden sm:table-cell">Data</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden lg:table-cell">Orçamento</th>
                <th class="px-4 py-3 text-right text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/[0.04]">
            @forelse($pedidos as $pedido)
            <tr class="hover:bg-white/[0.02] transition-colors group">
                <td class="px-6 py-4">
                    <div class="font-medium text-white">{{ $pedido->name }}</div>
                    <div class="text-xs text-zinc-500 mt-0.5">{{ $pedido->email }}</div>
                    @if($pedido->company)
                        <div class="text-xs text-zinc-600 mt-0.5">{{ $pedido->company }}</div>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <span class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 rounded-full
                                 {{ $packageColors[$pedido->package_type] ?? 'bg-zinc-700 text-zinc-300' }}">
                        {{ $packageLabels[$pedido->package_type] ?? $pedido->package_type }}
                    </span>
                </td>
                <td class="px-4 py-4">
                    <x-admin.status-badge :status="$pedido->status" type="package"/>
                </td>
                <td class="px-4 py-4 hidden sm:table-cell">
                    <span class="text-xs text-zinc-500" title="{{ $pedido->created_at->format('d/m/Y H:i') }}">
                        {{ $pedido->created_at->diffForHumans() }}
                    </span>
                </td>
                <td class="px-4 py-4 hidden lg:table-cell">
                    @if($pedido->budget)
                        <span class="text-sm text-zinc-300">{{ $pedido->budget }}</span>
                    @else
                        <span class="text-sm text-zinc-600">—</span>
                    @endif
                </td>
                <td class="px-4 py-4">
                    <div class="flex items-center justify-end gap-2">

                        {{-- Quick: marcar aprovado --}}
                        @if($pedido->status !== 'aprovado')
                            <form method="POST" action="{{ route('admin.pedidos.updateStatus', $pedido) }}">
                                @csrf @method('PATCH')
                                <input type="hidden" name="status" value="aprovado">
                                <button
                                    type="submit"
                                    title="Marcar como aprovado"
                                    class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500
                                           hover:text-emerald-400 hover:bg-emerald-500/10 transition-colors"
                                >
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </button>
                            </form>
                        @endif

                        {{-- Ver --}}
                        <a
                            href="{{ route('admin.pedidos.show', $pedido) }}"
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
                            action="{{ route('admin.pedidos.destroy', $pedido) }}"
                            x-data
                            @submit.prevent="if(confirm('Eliminar este pedido?')) $el.submit()"
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
                    Nenhum pedido encontrado.
                </td>
            </tr>
            @endforelse
        </tbody>

        <x-slot:footer>
            <x-admin.pagination :items="$pedidos"/>
        </x-slot:footer>

    </x-admin.table>

</div>

@endsection
