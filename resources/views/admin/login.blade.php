<!DOCTYPE html>
<html lang="pt" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login · Painel 99web</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta name="theme-color" content="#7C3AED">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#0A0612] font-sans antialiased flex items-center justify-center px-4 py-12">

    {{-- Background decoration --}}
    <div
        class="fixed inset-0 pointer-events-none"
        style="background: radial-gradient(ellipse 80% 60% at 50% -10%, rgba(124,58,237,0.20) 0%, transparent 60%);"
        aria-hidden="true"
    ></div>
    <div
        class="fixed inset-0 pointer-events-none opacity-[0.03]"
        style="background-image: radial-gradient(circle, #a855f7 1px, transparent 1px); background-size: 28px 28px;"
        aria-hidden="true"
    ></div>

    <div class="relative w-full max-w-sm">

        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-baseline gap-0.5 mb-3">
                <span class="text-3xl font-bold text-white tracking-tight">99</span><span class="text-3xl font-bold text-brand-accent tracking-tight">web</span>
            </a>
            <p class="text-sm text-zinc-500">Painel de Administração</p>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-violet-500/20 bg-[#14102A] p-8 shadow-2xl shadow-violet-950/50">

            <h1 class="text-lg font-semibold text-white mb-1">Bem-vindo de volta</h1>
            <p class="text-sm text-zinc-500 mb-7">Introduza as suas credenciais para continuar.</p>

            {{-- Session error --}}
            @if (session('error'))
                <div class="mb-5 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/25 text-sm text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" novalidate>
                @csrf

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-xs font-medium text-zinc-400 mb-2">
                        Email
                    </label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        class="w-full px-4 py-2.5 rounded-xl bg-white/5 border text-sm text-white placeholder-zinc-600
                               transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/50
                               @error('email') border-red-500/50 focus:ring-red-500/30 @else border-white/10 focus:border-violet-500/50 @enderror"
                        placeholder="admin@99web.pt"
                    >
                    @error('email')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-6">
                    <label for="password" class="block text-xs font-medium text-zinc-400 mb-2">
                        Password
                    </label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="w-full px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-sm text-white placeholder-zinc-600
                               transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-violet-500/50 focus:border-violet-500/50
                               @error('password') border-red-500/50 focus:ring-red-500/30 @enderror"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center mb-6">
                    <input
                        id="remember"
                        type="checkbox"
                        name="remember"
                        class="w-4 h-4 rounded border-white/20 bg-white/5 text-violet-600 focus:ring-violet-500/30"
                    >
                    <label for="remember" class="ml-2.5 text-xs text-zinc-400">Manter sessão iniciada</label>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    class="w-full py-2.5 rounded-xl text-sm font-semibold text-white
                           transition-all duration-200 hover:scale-[1.02] hover:shadow-lg hover:shadow-violet-500/25
                           focus:outline-none focus:ring-2 focus:ring-violet-500/50"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);"
                >
                    Entrar no painel
                </button>

            </form>
        </div>

        {{-- Back link --}}
        <p class="text-center mt-6 text-xs text-zinc-600">
            <a href="{{ route('home') }}" class="hover:text-zinc-400 transition-colors duration-200">
                ← Voltar ao site
            </a>
        </p>

    </div>

</body>
</html>
