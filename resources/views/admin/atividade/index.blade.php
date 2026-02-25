@extends('admin.layouts.admin')

@section('title', 'Atividade')

@section('breadcrumb', 'Atividade')

@section('content')

<div class="space-y-5">

    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Registo de Atividade</h1>
            <p class="text-sm text-zinc-500 mt-0.5">{{ $logs->count() }} ações registadas</p>
        </div>
    </div>

    {{-- Filtros rápidos --}}
    <div class="flex flex-wrap items-center gap-2">
        @php
            $currentAction = request('action');
            $currentModel  = request('model');
        @endphp

        <a href="{{ route('admin.atividade.index') }}"
           class="px-3 py-1.5 rounded-full text-xs font-medium transition-all
                  {{ !$currentAction && !$currentModel ? 'bg-violet-600 text-white' : 'text-zinc-400 border border-zinc-700 hover:text-white hover:border-zinc-500' }}">
            Tudo
        </a>

        @foreach(['created' => 'Criados', 'updated' => 'Atualizados', 'deleted' => 'Eliminados', 'published' => 'Publicados', 'export' => 'Exportados'] as $action => $label)
            <a href="{{ route('admin.atividade.index', ['action' => $action]) }}"
               class="px-3 py-1.5 rounded-full text-xs font-medium transition-all
                      {{ $currentAction === $action ? 'bg-violet-600 text-white' : 'text-zinc-400 border border-zinc-700 hover:text-white hover:border-zinc-500' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Tabela --}}
    <x-admin.table>
        <x-slot:header>
            <span class="text-sm font-semibold text-white">Atividade recente</span>
        </x-slot:header>

        <thead>
            <tr class="border-b border-white/5">
                <th class="text-left px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Ação</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden sm:table-cell">Descrição</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden md:table-cell">Admin</th>
                <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden lg:table-cell">IP</th>
                <th class="text-right px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Data</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/[0.04]">
            @forelse($logs as $log)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-6 py-3">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold {{ $log->actionColor() }}">
                        {{ $log->actionLabel() }}
                    </span>
                    @if($log->model_type)
                        <span class="ml-1.5 text-[11px] text-zinc-600">{{ $log->model_type }}</span>
                    @endif
                </td>
                <td class="px-4 py-3 hidden sm:table-cell">
                    <span class="text-sm text-zinc-300">{{ $log->description ?? '—' }}</span>
                </td>
                <td class="px-4 py-3 hidden md:table-cell">
                    <span class="text-sm text-zinc-400">{{ $log->admin?->name ?? 'Sistema' }}</span>
                </td>
                <td class="px-4 py-3 hidden lg:table-cell">
                    <span class="text-xs text-zinc-600 font-mono">{{ $log->ip_address ?? '—' }}</span>
                </td>
                <td class="px-4 py-3 text-right">
                    <span class="text-xs text-zinc-500" title="{{ $log->created_at->format('d/m/Y H:i:s') }}">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-14 text-center text-sm text-zinc-500">
                    Nenhuma atividade registada.
                </td>
            </tr>
            @endforelse
        </tbody>

    </x-admin.table>

</div>

@endsection
