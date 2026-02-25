@extends('admin.layouts.admin')

@section('title', 'Blog')
@section('breadcrumb', 'Blog')

@section('content')

<div
    class="space-y-5"
    x-data="{
        selected: [],
        selectAll: false,
        toggleAll() {
            this.selectAll = !this.selectAll;
            const boxes = document.querySelectorAll('.post-checkbox');
            this.selected = this.selectAll ? [...boxes].map(b => b.value) : [];
            boxes.forEach(b => b.checked = this.selectAll);
        },
        toggle(id) {
            const idx = this.selected.indexOf(id);
            if (idx > -1) this.selected.splice(idx, 1); else this.selected.push(id);
        },
        async togglePublish(postId, btn) {
            btn.disabled = true;
            const res = await fetch('{{ url('/admin/blog') }}/' + postId + '/publish', {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json' }
            });
            const data = await res.json();
            if (data.ok) window.location.reload();
            else btn.disabled = false;
        }
    }"
>

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Artigos</h1>
            <p class="text-sm text-zinc-500 mt-0.5">{{ $posts->total() }} artigos no total</p>
        </div>
        <a href="{{ route('admin.blog.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all"
           style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Novo Artigo
        </a>
    </div>

    {{-- ── Bulk actions bar ── --}}
    <div x-show="selected.length > 0" x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="rounded-xl border border-violet-500/30 bg-violet-500/10 px-5 py-3 flex items-center gap-4">
        <span class="text-sm text-violet-300 font-medium" x-text="selected.length + ' artigo(s) selecionado(s)'"></span>
        <form method="POST" action="{{ route('admin.blog.bulk') }}" class="flex items-center gap-2 ml-auto">
            @csrf
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="ids[]" :value="id">
            </template>
            <select name="action"
                    class="px-3 py-1.5 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white focus:outline-none focus:border-violet-500/60">
                <option value="publicar">Publicar</option>
                <option value="despublicar">Despublicar</option>
                <option value="eliminar">Eliminar</option>
            </select>
            <button type="submit"
                    onclick="if(this.closest('form').querySelector('select').value === 'eliminar' && !confirm('Eliminar os artigos selecionados?')) return false;"
                    class="px-4 py-1.5 rounded-lg text-sm font-medium text-white transition-colors"
                    style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
                Aplicar
            </button>
        </form>
    </div>

    {{-- ── Filtros ── --}}
    <x-admin.filter-bar :action="route('admin.blog.index')">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Pesquisa</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Título ou slug…"
                   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                          placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
        </div>
        <div class="w-40">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Estado</label>
            <select name="status"
                    class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                           focus:outline-none focus:border-violet-500/60 transition-colors appearance-none">
                <option value="">Todos</option>
                <option value="publicado" @selected(request('status') === 'publicado')>Publicado</option>
                <option value="agendado"  @selected(request('status') === 'agendado')>Agendado</option>
                <option value="rascunho"  @selected(request('status') === 'rascunho')>Rascunho</option>
            </select>
        </div>
        <div class="w-48">
            <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Categoria</label>
            <select name="categoria"
                    class="w-full px-3 py-2 rounded-lg bg-[#0F0A1A] border border-zinc-700 text-sm text-white
                           focus:outline-none focus:border-violet-500/60 transition-colors appearance-none">
                <option value="">Todas</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}" @selected(request('categoria') === $cat->slug)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
    </x-admin.filter-bar>

    {{-- ── Tabela ── --}}
    <x-admin.table>
        <x-slot:header>
            <span class="text-sm font-semibold text-white">Resultados</span>
            <span class="text-xs text-zinc-500">{{ $posts->count() }} nesta página</span>
        </x-slot:header>

        <thead>
            <tr class="border-b border-white/5">
                <th class="w-10 px-4 py-3">
                    <input type="checkbox" @change="toggleAll()"
                           class="w-4 h-4 rounded border-zinc-600 bg-zinc-800 accent-violet-500 cursor-pointer">
                </th>
                <th class="w-14 px-2 py-3"></th>
                <th class="px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Título</th>
                <th class="hidden md:table-cell px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Categoria</th>
                <th class="px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Estado</th>
                <th class="hidden lg:table-cell px-4 py-3 text-right text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Views</th>
                <th class="hidden sm:table-cell px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Data</th>
                <th class="px-4 py-3 text-right text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
            @forelse($posts as $post)
            @php
                $blogStatus = match(true) {
                    $post->is_published && $post->published_at && $post->published_at <= now() => 'publicado',
                    $post->is_published && $post->published_at && $post->published_at > now()  => 'agendado',
                    default => 'rascunho',
                };
            @endphp
            <tr class="hover:bg-white/[0.02] transition-colors">
                {{-- Checkbox --}}
                <td class="px-4 py-3">
                    <input type="checkbox" class="post-checkbox w-4 h-4 rounded border-zinc-600 bg-zinc-800 accent-violet-500 cursor-pointer"
                           value="{{ $post->id }}" @change="toggle('{{ $post->id }}')">
                </td>

                {{-- Imagem --}}
                <td class="px-2 py-3">
                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-zinc-800 flex-shrink-0">
                        @if($post->featured_image)
                            <img src="{{ $post->featured_image }}" alt="" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                </td>

                {{-- Título --}}
                <td class="px-4 py-3">
                    <a href="{{ route('admin.blog.edit', $post) }}"
                       class="text-sm font-medium text-white hover:text-violet-400 transition-colors line-clamp-1">
                        {{ $post->title }}
                    </a>
                    <p class="text-[11px] text-zinc-500 mt-0.5">{{ $post->slug }}</p>
                </td>

                {{-- Categoria --}}
                <td class="hidden md:table-cell px-4 py-3">
                    <span class="text-xs text-zinc-400">{{ $post->category->name ?? '—' }}</span>
                </td>

                {{-- Estado --}}
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <x-admin.status-badge :status="$blogStatus" type="blog"/>
                        <button
                            type="button"
                            title="{{ $post->is_published ? 'Despublicar' : 'Publicar' }}"
                            @click="togglePublish('{{ $post->id }}', $el)"
                            class="w-6 h-6 rounded flex items-center justify-center text-zinc-500 hover:text-violet-400 hover:bg-violet-500/10 transition-colors">
                            @if($post->is_published)
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                            @else
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            @endif
                        </button>
                    </div>
                </td>

                {{-- Views --}}
                <td class="hidden lg:table-cell px-4 py-3 text-right">
                    <span class="text-xs text-zinc-500">{{ number_format($post->views_count) }}</span>
                </td>

                {{-- Data --}}
                <td class="hidden sm:table-cell px-4 py-3">
                    <span class="text-xs text-zinc-400">
                        {{ $post->published_at?->format('d/m/Y') ?? $post->created_at->format('d/m/Y') }}
                    </span>
                </td>

                {{-- Ações --}}
                <td class="px-4 py-3">
                    <div class="flex items-center justify-end gap-1">
                        {{-- Editar --}}
                        <a href="{{ route('admin.blog.edit', $post) }}"
                           class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500 hover:text-violet-400 hover:bg-violet-500/10 transition-colors"
                           title="Editar">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                        </a>

                        {{-- Duplicar --}}
                        <form method="POST" action="{{ route('admin.blog.duplicate', $post) }}"
                              x-data @submit.prevent="if(confirm('Duplicar este artigo?')) $el.submit()">
                            @csrf
                            <button type="submit"
                                    class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500 hover:text-blue-400 hover:bg-blue-500/10 transition-colors"
                                    title="Duplicar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"/></svg>
                            </button>
                        </form>

                        {{-- Ver no site --}}
                        @if($post->is_published)
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
                           class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500 hover:text-emerald-400 hover:bg-emerald-500/10 transition-colors"
                           title="Ver no site">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                        </a>
                        @else
                        <a href="{{ route('admin.blog.preview', $post) }}" target="_blank"
                           class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500 hover:text-amber-400 hover:bg-amber-500/10 transition-colors"
                           title="Preview">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </a>
                        @endif

                        {{-- Eliminar --}}
                        <form method="POST" action="{{ route('admin.blog.destroy', $post) }}"
                              x-data @submit.prevent="if(confirm('Eliminar «{{ addslashes($post->title) }}»?')) $el.submit()">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-600 hover:text-red-400 hover:bg-red-500/10 transition-colors"
                                    title="Eliminar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-16 text-center">
                    <p class="text-sm text-zinc-500">Nenhum artigo encontrado.</p>
                    <a href="{{ route('admin.blog.create') }}" class="inline-block mt-3 text-xs text-violet-400 hover:underline">Criar o primeiro artigo →</a>
                </td>
            </tr>
            @endforelse
        </tbody>

        <x-slot:footer>
            <x-admin.pagination :items="$posts"/>
        </x-slot:footer>
    </x-admin.table>

</div>

@endsection
