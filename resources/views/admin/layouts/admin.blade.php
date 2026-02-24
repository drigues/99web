<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel') · 99web Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(124,58,237,.25); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: rgba(124,58,237,.4); }
    </style>
</head>
<body
    class="h-full bg-[#0A0612] font-sans antialiased text-white"
    x-data="{
        sidebarOpen: false,
        avatarOpen: false,
    }"
    @keydown.escape.window="sidebarOpen = false; avatarOpen = false"
>

@php
    $admin = Auth::guard('admin')->user();
    $notifCount = \App\Models\Contact::novo()->count()
               + \App\Models\PackageRequest::novo()->count()
               + \App\Models\MeetingRequest::pendente()->count();

    $navItems = [
        [
            'label'  => 'Dashboard',
            'href'   => route('admin.dashboard'),
            'match'  => 'admin',
            'exact'  => true,
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zm0 9.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zm9.75-9.75A2.25 2.25 0 0115.75 3.75H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zm0 9.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>',
        ],
        [
            'label'  => 'Contactos',
            'href'   => '/admin/contactos',
            'match'  => 'admin/contactos*',
            'exact'  => false,
            'badge'  => \App\Models\Contact::novo()->count(),
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>',
        ],
        [
            'label'  => 'Pedidos Pacotes',
            'href'   => '/admin/pedidos',
            'match'  => 'admin/pedidos*',
            'exact'  => false,
            'badge'  => \App\Models\PackageRequest::novo()->count(),
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>',
        ],
        [
            'label'  => 'Reuniões',
            'href'   => '/admin/reunioes',
            'match'  => 'admin/reunioes*',
            'exact'  => false,
            'badge'  => \App\Models\MeetingRequest::pendente()->count(),
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z"/></svg>',
        ],
        ['divider' => true],
        [
            'label'  => 'Blog',
            'href'   => '/admin/blog',
            'match'  => 'admin/blog',
            'exact'  => true,
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>',
        ],
        [
            'label'  => 'Categorias',
            'href'   => '/admin/blog/categorias',
            'match'  => 'admin/blog/categorias*',
            'exact'  => false,
            'indent' => true,
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>',
        ],
        ['divider' => true],
        [
            'label'  => 'Configurações',
            'href'   => '/admin/configuracoes',
            'match'  => 'admin/configuracoes*',
            'exact'  => false,
            'icon'   => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
        ],
    ];
@endphp

    {{-- ── Mobile overlay ── --}}
    <div
        x-show="sidebarOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false"
        class="fixed inset-0 z-20 bg-black/60 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- ════════════════════ SIDEBAR ════════════════════ --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-30 w-64 flex flex-col
               bg-[#0F0A1A] border-r border-zinc-800/60
               transition-transform duration-300 ease-out
               lg:translate-x-0"
        aria-label="Sidebar de navegação"
    >

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 h-16 border-b border-zinc-800/60 flex-shrink-0">
            <a href="{{ route('admin.dashboard') }}" class="flex items-baseline gap-0.5">
                <span class="text-xl font-bold text-white tracking-tight">99</span><span class="text-xl font-bold text-violet-400 tracking-tight">web</span>
            </a>
            <span class="text-[10px] font-bold text-violet-500/70 border border-violet-500/30 bg-violet-500/10 px-1.5 py-0.5 rounded uppercase tracking-wider">
                Admin
            </span>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5" aria-label="Menu principal">

            @foreach ($navItems as $item)

                @if(isset($item['divider']))
                    <div class="my-3 border-t border-zinc-800/60"></div>

                @else
                    @php
                        $isActive = $item['exact']
                            ? request()->is($item['match'])
                            : request()->is($item['match']);
                    @endphp

                    <a
                        href="{{ $item['href'] }}"
                        class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium
                               transition-all duration-150 group
                               {{ isset($item['indent']) ? 'pl-7' : '' }}
                               {{ $isActive
                                   ? 'bg-violet-600/15 border-l-2 border-violet-500 text-white pl-[10px]'
                                   : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50 border-l-2 border-transparent' }}"
                        aria-current="{{ $isActive ? 'page' : 'false' }}"
                    >
                        <span class="w-5 h-5 flex-shrink-0 {{ $isActive ? 'text-violet-400' : 'text-zinc-500 group-hover:text-zinc-300' }}">{!! $item['icon'] !!}</span>
                        <span class="flex-1 truncate">{{ $item['label'] }}</span>
                        @if(isset($item['badge']) && $item['badge'] > 0)
                            <span class="ml-auto flex-shrink-0 text-[10px] font-bold px-1.5 py-0.5 rounded-full
                                         {{ $isActive ? 'bg-violet-500/30 text-violet-200' : 'bg-violet-500/20 text-violet-400' }}">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>

                @endif

            @endforeach

        </nav>

        {{-- Admin user + logout --}}
        <div class="flex-shrink-0 border-t border-zinc-800/60 p-3">
            <div class="flex items-center gap-3 px-2 py-2.5">
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0"
                     style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    {{ mb_substr($admin->name ?? 'A', 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-white truncate">{{ $admin->name }}</p>
                    <p class="text-[10px] text-zinc-500 truncate">{{ $admin->role }}</p>
                </div>
                {{-- Logout --}}
                <form method="POST" action="{{ route('admin.logout') }}" class="flex-shrink-0">
                    @csrf
                    <button
                        type="submit"
                        title="Sair"
                        class="w-7 h-7 flex items-center justify-center rounded-md text-zinc-500 hover:text-red-400 hover:bg-red-500/10 transition-colors"
                    >
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>

    {{-- ════════════════════ MAIN WRAPPER ════════════════════ --}}
    <div class="lg:pl-64 flex flex-col min-h-screen">

        {{-- ── Topbar ── --}}
        <header class="sticky top-0 z-10 h-16 flex items-center justify-between px-6 gap-4
                        bg-[#1A1225] border-b border-zinc-800/60">

            {{-- Esquerda: hamburger + breadcrumb --}}
            <div class="flex items-center gap-4 min-w-0">

                {{-- Hamburger mobile --}}
                <button
                    @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden flex items-center justify-center w-8 h-8 rounded-md text-zinc-400 hover:text-white hover:bg-zinc-800/60 transition-colors"
                    :aria-label="sidebarOpen ? 'Fechar sidebar' : 'Abrir sidebar'"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                </button>

                {{-- Breadcrumb --}}
                <nav class="flex items-center gap-1.5 text-sm min-w-0" aria-label="Breadcrumb">
                    <a href="{{ route('admin.dashboard') }}" class="text-zinc-500 hover:text-zinc-300 transition-colors flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                        </svg>
                    </a>
                    @hasSection('breadcrumb')
                        <svg class="w-3 h-3 text-zinc-700 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                        <span class="text-white font-medium truncate">@yield('breadcrumb')</span>
                    @endif
                </nav>

            </div>

            {{-- Direita: notificações + avatar --}}
            <div class="flex items-center gap-3 flex-shrink-0">

                {{-- Notificações --}}
                <button
                    class="relative flex items-center justify-center w-9 h-9 rounded-lg text-zinc-400 hover:text-white hover:bg-zinc-800/60 transition-colors"
                    title="Notificações"
                    aria-label="Ver notificações"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/>
                    </svg>
                    @if($notifCount > 0)
                        <span id="notif-badge"
                              class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-[9px] font-bold text-white flex items-center justify-center"
                              style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                            {{ $notifCount > 9 ? '9+' : $notifCount }}
                        </span>
                    @else
                        <span id="notif-badge"
                              class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full text-[9px] font-bold text-white flex items-center justify-center"
                              style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%); display: none;">0</span>
                    @endif
                </button>

                {{-- Avatar dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">

                    <button
                        @click="open = !open"
                        class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg hover:bg-zinc-800/60 transition-colors"
                        :aria-expanded="open.toString()"
                        aria-label="Menu do utilizador"
                    >
                        <div class="w-7 h-7 rounded-full flex items-center justify-center text-[11px] font-bold text-white flex-shrink-0"
                             style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                            {{ mb_substr($admin->name ?? 'A', 0, 1) }}
                        </div>
                        <span class="text-sm font-medium text-zinc-300 hidden sm:block">{{ $admin->name }}</span>
                        <svg class="w-3.5 h-3.5 text-zinc-500 transition-transform duration-150" :class="open ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="open"
                        x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                        class="absolute right-0 top-full mt-1.5 w-52 rounded-xl border border-zinc-800 bg-[#1A1225] shadow-2xl shadow-black/40 overflow-hidden"
                        role="menu"
                    >
                        <div class="px-4 py-3 border-b border-zinc-800/60">
                            <p class="text-xs font-semibold text-white truncate">{{ $admin->name }}</p>
                            <p class="text-[11px] text-zinc-500 truncate">{{ $admin->email }}</p>
                        </div>
                        <div class="py-1">
                            <a href="/admin/configuracoes" class="flex items-center gap-2.5 px-4 py-2 text-sm text-zinc-400 hover:text-white hover:bg-zinc-800/50 transition-colors" role="menuitem">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Configurações
                            </a>
                            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 px-4 py-2 text-sm text-zinc-400 hover:text-white hover:bg-zinc-800/50 transition-colors" role="menuitem">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                Ver site
                            </a>
                        </div>
                        <div class="border-t border-zinc-800/60 py-1">
                            <form method="POST" action="{{ route('admin.logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-colors" role="menuitem">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/></svg>
                                    Terminar sessão
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </div>

        </header>

        {{-- ── Content area ── --}}
        <main class="flex-1 bg-[#0A0612] p-6" id="main-content">

            {{-- Flash — sucesso --}}
            @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-2"
                    class="flex items-center gap-3 mb-5 px-4 py-3 rounded-xl
                           bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm"
                    role="alert"
                >
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="flex-1">{{ session('success') }}</span>
                    <button @click="show = false" class="text-emerald-500/60 hover:text-emerald-400 transition-colors" aria-label="Fechar">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            {{-- Flash — erro --}}
            @if(session('error') || $errors->any())
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="flex items-start gap-3 mb-5 px-4 py-3 rounded-xl
                           bg-red-500/10 border border-red-500/20 text-red-400 text-sm"
                    role="alert"
                >
                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                    <div class="flex-1">
                        @if(session('error'))
                            {{ session('error') }}
                        @elseif($errors->any())
                            <ul class="space-y-0.5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <button @click="show = false" class="text-red-500/60 hover:text-red-400 transition-colors flex-shrink-0" aria-label="Fechar">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @stack('scripts')

    {{-- Polling notificações (a cada 60s) --}}
    <script>
    (function () {
        const badge = document.getElementById('notif-badge');
        if (!badge) return;

        async function pollNotifs() {
            try {
                const r = await fetch('{{ route('admin.api.notifications-count') }}', {
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                if (!r.ok) return;
                const data = await r.json();
                const count = data.count ?? 0;
                badge.textContent = count > 9 ? '9+' : count;
                badge.style.display = count > 0 ? '' : 'none';
            } catch {}
        }

        setInterval(pollNotifs, 60000);
    })();
    </script>

</body>
</html>
