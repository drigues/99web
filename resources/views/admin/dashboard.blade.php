@extends('admin.layouts.admin')

@section('title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')

@php
    $statCards = [
        [
            'label' => 'Contactos Novos',
            'value' => $stats['contacts_novos'],
            'total' => $stats['contacts'],
            'color' => 'violet',
            'href'  => '/admin/contactos',
            'icon'  => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>',
        ],
        [
            'label' => 'Pedidos Pendentes',
            'value' => $stats['package_novos'],
            'total' => $stats['package_requests'],
            'color' => 'blue',
            'href'  => '/admin/pedidos',
            'icon'  => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>',
        ],
        [
            'label' => 'Reuniões Pendentes',
            'value' => $stats['meetings_pending'],
            'total' => $stats['meetings'],
            'color' => 'green',
            'href'  => '/admin/reunioes',
            'icon'  => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>',
        ],
        [
            'label' => 'Posts Publicados',
            'value' => $stats['blog_published'],
            'total' => $stats['blog_posts'],
            'color' => 'orange',
            'href'  => '/admin/blog',
            'icon'  => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>',
        ],
    ];

    $colorMap = [
        'violet' => ['bg' => 'bg-violet-500/10', 'border' => 'border-violet-500/20', 'icon' => 'text-violet-400', 'badge' => 'bg-violet-500/20 text-violet-300'],
        'blue'   => ['bg' => 'bg-blue-500/10',   'border' => 'border-blue-500/20',   'icon' => 'text-blue-400',   'badge' => 'bg-blue-500/20 text-blue-300'],
        'green'  => ['bg' => 'bg-emerald-500/10', 'border' => 'border-emerald-500/20','icon' => 'text-emerald-400','badge' => 'bg-emerald-500/20 text-emerald-300'],
        'orange' => ['bg' => 'bg-orange-500/10', 'border' => 'border-orange-500/20', 'icon' => 'text-orange-400', 'badge' => 'bg-orange-500/20 text-orange-300'],
    ];

    $typeConfig = [
        'contact' => ['bg' => 'bg-violet-500/15', 'text' => 'text-violet-300'],
        'package' => ['bg' => 'bg-blue-500/15',   'text' => 'text-blue-300'],
        'meeting' => ['bg' => 'bg-emerald-500/15','text' => 'text-emerald-300'],
    ];

    $statusConfig = [
        'novo'                => ['bg' => 'bg-violet-500/15', 'text' => 'text-violet-300'],
        'pendente'            => ['bg' => 'bg-amber-500/15',  'text' => 'text-amber-300'],
        'respondido'          => ['bg' => 'bg-zinc-700/50',   'text' => 'text-zinc-400'],
        'contactado'          => ['bg' => 'bg-blue-500/15',   'text' => 'text-blue-300'],
        'proposta_enviada'    => ['bg' => 'bg-cyan-500/15',   'text' => 'text-cyan-300'],
        'aprovado'            => ['bg' => 'bg-emerald-500/15','text' => 'text-emerald-300'],
        'confirmado'          => ['bg' => 'bg-emerald-500/15','text' => 'text-emerald-300'],
        'recusado'            => ['bg' => 'bg-red-500/15',    'text' => 'text-red-400'],
        'cancelado'           => ['bg' => 'bg-red-500/15',    'text' => 'text-red-400'],
    ];
@endphp

<div class="space-y-6">

    {{-- ── Saudação ── --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Dashboard</h1>
            <p class="text-sm text-zinc-500 mt-0.5">
                Bem-vindo, {{ Auth::guard('admin')->user()->name }}.
            </p>
        </div>
        <span class="hidden sm:flex items-center gap-1.5 text-xs text-zinc-500 flex-shrink-0">
            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
            Sistema operacional
        </span>
    </div>

    {{-- ── Stat cards ── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        @foreach($statCards as $card)
        @php $c = $colorMap[$card['color']]; @endphp
        <a
            href="{{ $card['href'] }}"
            class="rounded-xl border bg-[#1A1225] p-5 flex flex-col gap-4
                   hover:border-white/20 transition-all duration-200
                   hover:shadow-lg hover:shadow-black/30 group {{ $c['border'] }}"
        >
            <div class="flex items-start justify-between gap-2">
                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 border {{ $c['bg'] }} {{ $c['border'] }}">
                    <span class="w-5 h-5 {{ $c['icon'] }}">{!! $card['icon'] !!}</span>
                </div>
                @if($card['value'] > 0)
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full flex-shrink-0 {{ $c['badge'] }}">
                        +{{ $card['value'] }}
                    </span>
                @endif
            </div>
            <div>
                <div class="text-3xl font-bold text-white tabular-nums">{{ $card['total'] }}</div>
                <div class="text-xs text-zinc-500 mt-0.5 group-hover:text-zinc-400 transition-colors">{{ $card['label'] }}</div>
            </div>
        </a>
        @endforeach

    </div>

    {{-- ── Gráfico + Resumo ── --}}
    <div class="grid xl:grid-cols-[1fr_360px] gap-6">

        {{-- Gráfico de contactos --}}
        <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
                <div>
                    <h2 class="text-sm font-semibold text-white">Contactos — últimos 30 dias</h2>
                    <p class="text-xs text-zinc-500 mt-0.5">Formulários recebidos por dia</p>
                </div>
                <span class="text-xs font-semibold text-violet-400 bg-violet-500/10 border border-violet-500/20 px-2.5 py-1 rounded-full">
                    {{ array_sum($chart_values) }} total
                </span>
            </div>
            <div class="p-6" style="height: 220px;">
                <canvas id="contacts-chart"></canvas>
            </div>
        </div>

        {{-- Painel de resumo --}}
        <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Visão geral</h2>
            </div>

            <div class="flex-1 divide-y divide-white/[0.04]">
                @foreach([
                    ['label' => 'Total contactos',   'value' => $stats['contacts'],         'sub' => $stats['contacts_novos'] . ' por responder'],
                    ['label' => 'Pedidos de pacote', 'value' => $stats['package_requests'], 'sub' => $stats['package_novos'] . ' novos'],
                    ['label' => 'Reuniões',           'value' => $stats['meetings'],         'sub' => $stats['meetings_pending'] . ' pendentes'],
                    ['label' => 'Posts publicados',  'value' => $stats['blog_published'],   'sub' => $stats['blog_posts'] . ' total'],
                ] as $row)
                    <div class="flex items-center justify-between px-6 py-3.5 hover:bg-white/[0.02] transition-colors">
                        <span class="text-sm text-zinc-400">{{ $row['label'] }}</span>
                        <div class="text-right">
                            <span class="text-sm font-bold text-white tabular-nums">{{ $row['value'] }}</span>
                            <span class="text-[10px] text-zinc-600 block leading-none mt-0.5">{{ $row['sub'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="px-4 py-4 border-t border-white/5 grid grid-cols-2 gap-2">
                @foreach([
                    ['label' => 'Contactos',  'href' => '/admin/contactos'],
                    ['label' => 'Pedidos',    'href' => '/admin/pedidos'],
                    ['label' => 'Reuniões',   'href' => '/admin/reunioes'],
                    ['label' => 'Blog',       'href' => '/admin/blog'],
                ] as $action)
                    <a
                        href="{{ $action['href'] }}"
                        class="flex items-center justify-center px-3 py-2 rounded-lg text-xs font-medium
                               text-zinc-400 border border-zinc-800 hover:border-violet-500/40
                               hover:text-violet-400 hover:bg-violet-500/5 transition-all duration-150"
                    >
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ── Tabela de atividade recente ── --}}
    <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">

        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h2 class="text-sm font-semibold text-white">Últimas atividades</h2>
            @if($recent_activity->isNotEmpty())
                <span class="text-xs text-zinc-500">{{ $recent_activity->count() }} registos</span>
            @endif
        </div>

        @if($recent_activity->isEmpty())
            <div class="py-14 text-center">
                <div class="w-12 h-12 rounded-full bg-zinc-800/60 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm text-zinc-500">Sem atividade registada ainda.</p>
            </div>

        @else

            {{-- Tabela (desktop) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5">
                            <th class="text-left px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider w-28">Tipo</th>
                            <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Nome</th>
                            <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider hidden lg:table-cell">Email</th>
                            <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Data</th>
                            <th class="text-left px-4 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Estado</th>
                            <th class="px-4 py-3 w-16"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.04]">
                        @foreach($recent_activity as $item)
                        @php
                            $tc = $typeConfig[$item['type']] ?? ['bg' => 'bg-zinc-700/50', 'text' => 'text-zinc-400'];
                            $sc = $statusConfig[$item['status']] ?? ['bg' => 'bg-zinc-700/50', 'text' => 'text-zinc-400'];
                        @endphp
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-3.5">
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-md w-fit {{ $tc['bg'] }} {{ $tc['text'] }}">
                                        {{ $item['label'] }}
                                    </span>
                                    @if($item['sublabel'])
                                        <span class="text-[10px] text-zinc-600 ml-0.5">{{ $item['sublabel'] }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="font-medium text-white">{{ $item['name'] }}</span>
                            </td>
                            <td class="px-4 py-3.5 hidden lg:table-cell">
                                <span class="text-zinc-400">{{ $item['email'] }}</span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-zinc-500 whitespace-nowrap text-xs" title="{{ $item['date']->format('d/m/Y H:i') }}">
                                    {{ $item['date']->diffForHumans() }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-right">
                                <a
                                    href="{{ $item['href'] }}"
                                    class="text-xs text-zinc-600 hover:text-violet-400 transition-colors font-medium"
                                    aria-label="Ver detalhes de {{ $item['name'] }}"
                                >
                                    Ver →
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Lista (mobile) --}}
            <div class="md:hidden divide-y divide-white/[0.04]">
                @foreach($recent_activity as $item)
                @php
                    $tc = $typeConfig[$item['type']] ?? ['bg' => 'bg-zinc-700/50', 'text' => 'text-zinc-400'];
                    $sc = $statusConfig[$item['status']] ?? ['bg' => 'bg-zinc-700/50', 'text' => 'text-zinc-400'];
                @endphp
                <a href="{{ $item['href'] }}" class="flex items-center gap-3 px-5 py-4 hover:bg-white/[0.02] transition-colors">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-0.5">
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded {{ $tc['bg'] }} {{ $tc['text'] }}">{{ $item['label'] }}</span>
                            <span class="text-sm font-medium text-white truncate">{{ $item['name'] }}</span>
                        </div>
                        <div class="text-xs text-zinc-500 truncate">{{ $item['email'] }}</div>
                    </div>
                    <div class="flex-shrink-0 text-right">
                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full block mb-1 {{ $sc['bg'] }} {{ $sc['text'] }}">{{ $item['status'] }}</span>
                        <span class="text-[10px] text-zinc-600">{{ $item['date']->diffForHumans() }}</span>
                    </div>
                </a>
                @endforeach
            </div>

        @endif

    </div>

</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function () {
    const labels = @json($chart_labels);
    const values = @json($chart_values);

    const canvas = document.getElementById('contacts-chart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 180);
    gradient.addColorStop(0, 'rgba(124, 58, 237, 0.40)');
    gradient.addColorStop(1, 'rgba(124, 58, 237, 0.02)');

    new Chart(canvas, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Contactos',
                data: values,
                borderColor: '#7C3AED',
                borderWidth: 2,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#7C3AED',
                pointBorderColor: '#1A1225',
                pointBorderWidth: 2,
                pointRadius: values.some(v => v > 0) ? 3 : 0,
                pointHoverRadius: 5,
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1E1435',
                    borderColor: 'rgba(124, 58, 237, 0.3)',
                    borderWidth: 1,
                    titleColor: '#a78bfa',
                    bodyColor: '#e4e4e7',
                    padding: 10,
                    callbacks: {
                        label: (item) => ` ${item.raw} contacto${item.raw !== 1 ? 's' : ''}`,
                    },
                },
            },
            scales: {
                x: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#52525b', font: { size: 10 }, maxTicksLimit: 8 },
                    border: { color: 'transparent' },
                },
                y: {
                    grid: { color: 'rgba(255,255,255,0.04)' },
                    ticks: { color: '#52525b', font: { size: 10 }, precision: 0, stepSize: 1 },
                    border: { color: 'transparent' },
                    beginAtZero: true,
                    min: 0,
                },
            },
        },
    });
})();
</script>
@endpush
