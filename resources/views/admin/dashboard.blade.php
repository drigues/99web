<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · Painel 99web</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0A0612] font-sans antialiased text-white min-h-screen">

    {{-- Topbar --}}
    <header class="border-b border-zinc-800/60 bg-[#0F0A1A]/90 backdrop-blur-md sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-6 h-14 flex items-center justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-baseline gap-0.5">
                <span class="text-xl font-bold text-white">99</span><span class="text-xl font-bold text-brand-accent">web</span>
                <span class="ml-2 text-xs font-medium text-zinc-500">Admin</span>
            </a>
            <div class="flex items-center gap-4">
                <span class="text-xs text-zinc-500 hidden sm:block">
                    {{ Auth::guard('admin')->user()->name }}
                </span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-zinc-400 hover:text-violet-400 transition-colors">
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-10">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-white">Dashboard</h1>
            <p class="text-sm text-zinc-500 mt-1">Bem-vindo, {{ Auth::guard('admin')->user()->name }}.</p>
        </div>

        {{-- Stats grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

            @foreach ([
                ['label' => 'Contactos',          'value' => $stats['contacts'],         'badge' => $stats['contacts_novos'],   'color' => '#7C3AED'],
                ['label' => 'Pedidos de Pacote',  'value' => $stats['package_requests'], 'badge' => $stats['package_novos'],    'color' => '#9333EA'],
                ['label' => 'Reuniões',            'value' => $stats['meetings'],         'badge' => $stats['meetings_pending'], 'color' => '#A855F7'],
                ['label' => 'Posts do Blog',       'value' => $stats['blog_posts'],       'badge' => $stats['blog_published'],   'color' => '#6D28D9'],
            ] as $stat)
                <div class="rounded-2xl border border-violet-500/15 bg-[#14102A] p-5">
                    <div class="flex items-start justify-between mb-3">
                        <span class="text-xs font-medium text-zinc-500">{{ $stat['label'] }}</span>
                        @if ($stat['badge'] > 0)
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-violet-500/20 text-violet-300">
                                {{ $stat['badge'] }} novos
                            </span>
                        @endif
                    </div>
                    <div class="text-3xl font-bold text-white">{{ $stat['value'] }}</div>
                </div>
            @endforeach

        </div>

        {{-- Recent contacts --}}
        <div class="rounded-2xl border border-violet-500/15 bg-[#14102A] overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5">
                <h2 class="text-sm font-semibold text-white">Contactos Recentes</h2>
            </div>
            @if ($recent_contacts->isEmpty())
                <div class="px-6 py-10 text-center text-sm text-zinc-500">
                    Nenhum contacto ainda.
                </div>
            @else
                <div class="divide-y divide-white/5">
                    @foreach ($recent_contacts as $contact)
                        <div class="px-6 py-4 flex items-center justify-between gap-4">
                            <div class="min-w-0">
                                <div class="text-sm font-medium text-white truncate">{{ $contact->name }}</div>
                                <div class="text-xs text-zinc-500 mt-0.5 truncate">{{ $contact->email }}</div>
                            </div>
                            <div class="flex items-center gap-3 flex-shrink-0">
                                <span class="text-[10px] font-medium px-2 py-1 rounded-full
                                    {{ $contact->status === 'novo' ? 'bg-violet-500/20 text-violet-300' : 'bg-white/5 text-zinc-400' }}">
                                    {{ $contact->status }}
                                </span>
                                <span class="text-xs text-zinc-600">{{ $contact->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>

</body>
</html>
