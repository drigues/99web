@extends('admin.layouts.admin')

@section('title', 'Meu Perfil')

@section('breadcrumb', 'Perfil')

@section('content')

<div class="max-w-2xl space-y-5">

    <div>
        <h1 class="text-xl font-bold text-white">Meu Perfil</h1>
        <p class="text-sm text-zinc-500 mt-0.5">Editar informações pessoais e senha de acesso</p>
    </div>

    {{-- ── Informações pessoais ─────────────────────────── --}}
    <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5">
        <h2 class="text-sm font-semibold text-white mb-5">Informações pessoais</h2>

        <form method="POST" action="{{ route('admin.perfil.update') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            {{-- Avatar --}}
            <div
                x-data="{
                    preview: '{{ $admin->avatar ?? '' }}',
                    handleFile(e) {
                        const file = e.target.files[0];
                        if (!file) return;
                        if (file.size > 1024 * 1024) { window.toast('Imagem demasiado grande (máx. 1 MB).', 'error'); return; }
                        const reader = new FileReader();
                        reader.onload = (ev) => this.preview = ev.target.result;
                        reader.readAsDataURL(file);
                    }
                }"
                class="flex items-center gap-4"
            >
                <div class="flex-shrink-0">
                    <template x-if="preview">
                        <img :src="preview" alt="Avatar" class="w-16 h-16 rounded-full object-cover border-2 border-zinc-700">
                    </template>
                    <template x-if="!preview">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white"
                             style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                            {{ mb_substr($admin->name, 0, 1) }}
                        </div>
                    </template>
                </div>
                <div>
                    <label class="cursor-pointer inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium
                                  text-zinc-400 border border-zinc-700 hover:border-zinc-500 hover:text-white transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/></svg>
                        Carregar imagem
                        <input type="file" name="avatar" accept="image/*" class="hidden" @change="handleFile">
                    </label>
                    <p class="text-[11px] text-zinc-600 mt-1">PNG, JPG ou WebP — máx. 1 MB</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Nome</label>
                    <input type="text" name="name" value="{{ old('name', $admin->name) }}" required
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                               focus:outline-none focus:border-violet-500/60 transition-colors
                               @error('name') border-red-500/60 @enderror">
                    @error('name')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $admin->email) }}" required
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                               focus:outline-none focus:border-violet-500/60 transition-colors
                               @error('email') border-red-500/60 @enderror">
                    @error('email')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-1 text-xs text-zinc-600">
                Função: <span class="text-zinc-400">{{ $admin->role }}</span>
                · Último login: <span class="text-zinc-400">{{ $admin->last_login_at?->diffForHumans() ?? 'N/D' }}</span>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    Guardar perfil
                </button>
            </div>
        </form>
    </div>

    {{-- ── Alterar senha ────────────────────────────────── --}}
    <div class="bg-[#0F0A1A] rounded-xl border border-zinc-800/60 p-5">
        <h2 class="text-sm font-semibold text-white mb-5">Alterar senha</h2>

        <form method="POST" action="{{ route('admin.perfil.password') }}" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-xs font-medium text-zinc-400 mb-1.5">Senha atual</label>
                <input type="password" name="current_password" autocomplete="current-password" required
                    class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                           focus:outline-none focus:border-violet-500/60 transition-colors
                           @error('current_password') border-red-500/60 @enderror">
                @error('current_password')
                    <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Nova senha</label>
                    <input type="password" name="new_password" autocomplete="new-password" required
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                               focus:outline-none focus:border-violet-500/60 transition-colors
                               @error('new_password') border-red-500/60 @enderror">
                    @error('new_password')
                        <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-zinc-400 mb-1.5">Confirmar nova senha</label>
                    <input type="password" name="new_password_confirmation" autocomplete="new-password" required
                        class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                               focus:outline-none focus:border-violet-500/60 transition-colors">
                </div>
            </div>

            <div class="flex justify-end pt-1">
                <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-all hover:opacity-90 bg-zinc-700 hover:bg-zinc-600">
                    Alterar senha
                </button>
            </div>
        </form>
    </div>

</div>

@endsection
