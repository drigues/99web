@props(['status', 'type' => 'contact'])

@php
$map = [
    'contact' => [
        'novo'       => ['bg' => 'bg-violet-500/20', 'text' => 'text-violet-300',  'dot' => 'bg-violet-400',  'label' => 'Novo'],
        'em_analise' => ['bg' => 'bg-amber-500/20',  'text' => 'text-amber-300',   'dot' => 'bg-amber-400',   'label' => 'Em análise'],
        'respondido' => ['bg' => 'bg-emerald-500/20','text' => 'text-emerald-300', 'dot' => 'bg-emerald-400', 'label' => 'Respondido'],
        'fechado'    => ['bg' => 'bg-zinc-700/50',   'text' => 'text-zinc-400',    'dot' => 'bg-zinc-500',    'label' => 'Fechado'],
    ],
    'package' => [
        'novo'             => ['bg' => 'bg-violet-500/20', 'text' => 'text-violet-300',  'dot' => 'bg-violet-400',  'label' => 'Novo'],
        'contactado'       => ['bg' => 'bg-blue-500/20',   'text' => 'text-blue-300',    'dot' => 'bg-blue-400',    'label' => 'Contactado'],
        'proposta_enviada' => ['bg' => 'bg-cyan-500/20',   'text' => 'text-cyan-300',    'dot' => 'bg-cyan-400',    'label' => 'Proposta enviada'],
        'aprovado'         => ['bg' => 'bg-emerald-500/20','text' => 'text-emerald-300', 'dot' => 'bg-emerald-400', 'label' => 'Aprovado'],
        'recusado'         => ['bg' => 'bg-red-500/20',    'text' => 'text-red-400',     'dot' => 'bg-red-400',     'label' => 'Recusado'],
    ],
    'meeting' => [
        'pendente'   => ['bg' => 'bg-amber-500/20',  'text' => 'text-amber-300',   'dot' => 'bg-amber-400',   'label' => 'Pendente'],
        'confirmado' => ['bg' => 'bg-emerald-500/20','text' => 'text-emerald-300', 'dot' => 'bg-emerald-400', 'label' => 'Confirmado'],
        'cancelado'  => ['bg' => 'bg-red-500/20',    'text' => 'text-red-400',     'dot' => 'bg-red-400',     'label' => 'Cancelado'],
    ],
    'blog' => [
        'publicado' => ['bg' => 'bg-emerald-500/20', 'text' => 'text-emerald-300', 'dot' => 'bg-emerald-400', 'label' => 'Publicado'],
        'agendado'  => ['bg' => 'bg-amber-500/20',   'text' => 'text-amber-300',   'dot' => 'bg-amber-400',   'label' => 'Agendado'],
        'rascunho'  => ['bg' => 'bg-zinc-700/50',    'text' => 'text-zinc-400',    'dot' => 'bg-zinc-500',    'label' => 'Rascunho'],
    ],
];

$c = $map[$type][$status] ?? ['bg' => 'bg-zinc-700/50', 'text' => 'text-zinc-400', 'dot' => 'bg-zinc-500', 'label' => ucfirst(str_replace('_', ' ', $status))];
@endphp

<span class="inline-flex items-center gap-1.5 text-[11px] font-semibold px-2.5 py-1 rounded-full {{ $c['bg'] }} {{ $c['text'] }}">
    <span class="w-1.5 h-1.5 rounded-full flex-shrink-0 {{ $c['dot'] }}"></span>
    {{ $c['label'] }}
</span>
