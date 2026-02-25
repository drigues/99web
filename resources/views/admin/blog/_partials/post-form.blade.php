{{--
    Shared form partial for creating/editing a blog post.
    Variables: $post (BlogPost|null), $categories, $tags, $authors
    $formAction and $formMethod are set by the parent view.
--}}

@php
    $isEdit         = !is_null($post);
    $formAction     = $isEdit ? route('admin.blog.update', $post) : route('admin.blog.store');
    $formMethod     = $isEdit ? 'PUT' : 'POST';
    $selectedTags   = $post?->tags->pluck('id')->toArray() ?? [];
    $currentAuthor  = $post?->author_id ?? auth()->guard('admin')->id();
    $currentCat     = $post?->category_id ?? '';
    $publishedAt    = $post?->published_at?->format('Y-m-d\TH:i') ?? now()->format('Y-m-d\TH:i');
@endphp

<form
    method="POST"
    action="{{ $formAction }}"
    id="post-form"
    x-data="{
        title: @js($post?->title ?? ''),
        slug: @js($post?->slug ?? ''),
        slugManual: {{ $isEdit ? 'true' : 'false' }},
        excerpt: @js($post?->excerpt ?? ''),
        metaTitle: @js($post?->meta_title ?? ''),
        metaDesc: @js($post?->meta_description ?? ''),
        isPublished: {{ ($post?->is_published ?? false) ? 'true' : 'false' }},
        featuredImage: @js($post?->featured_image ?? ''),
        ogImage: @js($post?->og_image ?? ''),
        selectedTags: @js($selectedTags),
        tagInput: '',
        seoOpen: {{ ($post?->meta_title || $post?->meta_description) ? 'true' : 'false' }},
        categoryModalOpen: false,
        newCatName: '',
        newCatSaving: false,

        generateSlug(value) {
            if (this.slugManual) return;
            this.slug = value
                .toLowerCase()
                .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
                .replace(/[^a-z0-9\s-]/g, '')
                .trim()
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-');
        },

        addTag(tagId, tagName) {
            tagId = String(tagId);
            if (!this.selectedTags.includes(tagId)) {
                this.selectedTags.push(tagId);
            }
            this.tagInput = '';
        },

        removeTag(tagId) {
            this.selectedTags = this.selectedTags.filter(t => String(t) !== String(tagId));
        },

        tagName(tagId) {
            const t = allTags.find(t => String(t.id) === String(tagId));
            return t ? t.name : tagId;
        },

        filteredTags() {
            if (!this.tagInput) return [];
            return allTags.filter(t =>
                t.name.toLowerCase().includes(this.tagInput.toLowerCase()) &&
                !this.selectedTags.includes(String(t.id))
            ).slice(0, 8);
        },

        async createCategory() {
            if (!this.newCatName.trim()) return;
            this.newCatSaving = true;
            try {
                const res = await fetch('{{ route('admin.blog.categorias.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ name: this.newCatName }),
                });
                const data = await res.json();
                if (data.ok) {
                    const sel = document.getElementById('category_id');
                    const opt = new Option(data.category.name, data.category.id, true, true);
                    sel.add(opt);
                    this.categoryModalOpen = false;
                    this.newCatName = '';
                }
            } finally {
                this.newCatSaving = false;
            }
        },

        submitDraft() {
            this.isPublished = false;
            this.$nextTick(() => { document.getElementById('post-form').submit(); });
        },

        submitPublish() {
            this.isPublished = true;
            this.$nextTick(() => { document.getElementById('post-form').submit(); });
        }
    }"
    @keydown.escape="categoryModalOpen = false"
>
    @csrf
    @if($formMethod === 'PUT')
        @method('PUT')
    @endif

    {{-- Hidden fields driven by Alpine --}}
    <input type="hidden" name="is_published" :value="isPublished ? '1' : '0'">

    <div class="grid lg:grid-cols-[1fr_380px] gap-6 items-start">

        {{-- ══════════════════════════════════════════════
             COLUNA PRINCIPAL
        ══════════════════════════════════════════════ --}}
        <div class="space-y-5">

            {{-- Validação (erros) --}}
            @if($errors->any())
            <div class="rounded-xl border border-red-500/30 bg-red-500/10 px-5 py-4">
                <p class="text-sm font-semibold text-red-400 mb-2">Corrige os erros antes de guardar:</p>
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li class="text-xs text-red-300 flex items-start gap-1.5">
                            <span class="mt-0.5 w-1 h-1 rounded-full bg-red-400 flex-shrink-0"></span>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Título --}}
            <div>
                <input
                    type="text"
                    name="title"
                    x-model="title"
                    @input="generateSlug($event.target.value)"
                    placeholder="Título do artigo…"
                    value="{{ old('title', $post?->title) }}"
                    class="w-full px-4 py-3 rounded-xl bg-[#1A1225] border border-zinc-800/60 text-2xl font-bold text-white
                           placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
                >
                @error('title')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Slug --}}
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Slug (URL)</label>
                <div class="flex items-center rounded-xl bg-[#1A1225] border border-zinc-800/60 focus-within:border-violet-500/60 transition-colors overflow-hidden">
                    <span class="px-3 py-2.5 text-sm text-zinc-600 border-r border-zinc-800/60 whitespace-nowrap bg-zinc-900/30">
                        99web.pt/blog/
                    </span>
                    <input
                        type="text"
                        name="slug"
                        x-model="slug"
                        @focus="slugManual = true"
                        placeholder="slug-do-artigo"
                        class="flex-1 px-3 py-2.5 text-sm text-violet-300 bg-transparent focus:outline-none"
                    >
                </div>
                @error('slug')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Excerpt --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Excerto *</label>
                    <span class="text-[10px] text-zinc-600" x-text="excerpt.length + '/300'"></span>
                </div>
                <textarea
                    name="excerpt"
                    x-model="excerpt"
                    rows="3"
                    maxlength="300"
                    placeholder="Resumo curto do artigo que aparece nas listagens e redes sociais…"
                    class="w-full px-4 py-3 rounded-xl bg-[#1A1225] border border-zinc-800/60 text-sm text-white
                           placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none"
                >{{ old('excerpt', $post?->excerpt) }}</textarea>
                @error('excerpt')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            {{-- Editor TinyMCE --}}
            <div>
                <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Conteúdo *</label>
                <div class="rounded-xl overflow-hidden border border-zinc-800/60 focus-within:border-violet-500/60 transition-colors">
                    <textarea
                        id="post-content"
                        name="content"
                        class="w-full"
                    >{{ old('content', $post?->content) }}</textarea>
                </div>
                @error('content')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

        </div>

        {{-- ══════════════════════════════════════════════
             COLUNA LATERAL
        ══════════════════════════════════════════════ --}}
        <div class="space-y-4">

            {{-- ── Card Publicação ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5">
                    <h3 class="text-sm font-semibold text-white">Publicação</h3>
                </div>
                <div class="p-5 space-y-4">

                    {{-- Toggle status --}}
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-zinc-400">Estado</span>
                        <button type="button" @click="isPublished = !isPublished"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 rounded-full border-2 border-transparent cursor-pointer transition-colors"
                                :class="isPublished ? 'bg-emerald-500' : 'bg-zinc-700'"
                                role="switch" :aria-checked="isPublished">
                            <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition"
                                  :class="isPublished ? 'translate-x-5' : 'translate-x-0'"></span>
                        </button>
                    </div>
                    <p class="text-xs font-medium -mt-2"
                       :class="isPublished ? 'text-emerald-400' : 'text-zinc-500'"
                       x-text="isPublished ? 'Publicado' : 'Rascunho'"></p>

                    {{-- Data publicação --}}
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">
                            Data de publicação
                        </label>
                        <input
                            type="datetime-local"
                            name="published_at"
                            value="{{ old('published_at', $publishedAt) }}"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                   focus:outline-none focus:border-violet-500/60 transition-colors"
                        >
                    </div>

                    {{-- Botões --}}
                    <div class="flex gap-2 pt-1">
                        <button
                            type="button"
                            @click="submitDraft()"
                            class="flex-1 py-2 rounded-lg text-xs font-medium text-zinc-300 border border-zinc-700 hover:border-zinc-500 hover:text-white transition-colors">
                            Guardar Rascunho
                        </button>
                        <button
                            type="button"
                            @click="submitPublish()"
                            class="flex-1 py-2 rounded-lg text-xs font-semibold text-white transition-all"
                            style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
                            {{ $isEdit ? 'Atualizar' : 'Publicar' }}
                        </button>
                    </div>

                    {{-- Preview (só em edição) --}}
                    @if($isEdit)
                    <a href="{{ route('admin.blog.preview', $post) }}" target="_blank"
                       class="flex items-center gap-1.5 text-xs text-zinc-500 hover:text-violet-400 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Pré-visualizar
                    </a>
                    @endif

                </div>
            </div>

            {{-- ── Card SEO ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <button type="button" @click="seoOpen = !seoOpen"
                        class="w-full px-5 py-4 flex items-center justify-between hover:bg-white/[0.02] transition-colors">
                    <h3 class="text-sm font-semibold text-white">SEO</h3>
                    <svg class="w-4 h-4 text-zinc-500 transition-transform" :class="seoOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/></svg>
                </button>

                <div x-show="seoOpen" x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="px-5 pb-5 space-y-4 border-t border-white/5 pt-4">

                    {{-- Meta Título --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Meta Título</label>
                            <span class="text-[10px]" :class="metaTitle.length > 60 ? 'text-red-400' : 'text-zinc-600'" x-text="metaTitle.length + '/60'"></span>
                        </div>
                        <input type="text" name="meta_title" x-model="metaTitle" maxlength="80"
                               value="{{ old('meta_title', $post?->meta_title) }}"
                               placeholder="Título para motores de busca…"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>

                    {{-- Meta Descrição --}}
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Meta Descrição</label>
                            <span class="text-[10px]" :class="metaDesc.length > 160 ? 'text-red-400' : 'text-zinc-600'" x-text="metaDesc.length + '/160'"></span>
                        </div>
                        <textarea name="meta_description" x-model="metaDesc" rows="3" maxlength="200"
                                  placeholder="Descrição para motores de busca…"
                                  class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                         placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none"
                        >{{ old('meta_description', $post?->meta_description) }}</textarea>
                    </div>

                    {{-- Meta Keywords --}}
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Meta Keywords</label>
                        <input type="text" name="meta_keywords"
                               value="{{ old('meta_keywords', $post?->meta_keywords) }}"
                               placeholder="palavra1, palavra2, palavra3…"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>

                    {{-- URL Canónica --}}
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">URL Canónica <span class="font-normal text-zinc-600">(opcional)</span></label>
                        <input type="url" name="canonical_url"
                               value="{{ old('canonical_url', $post?->canonical_url) }}"
                               placeholder="https://…"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                        @error('canonical_url')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>

                    {{-- Google Preview --}}
                    <div class="rounded-lg border border-zinc-800/60 bg-[#0F0A1A] p-4">
                        <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-3">Preview Google</p>
                        <div class="space-y-1">
                            <p class="text-[11px] text-green-600 truncate" x-text="'99web.pt/blog/' + slug"></p>
                            <p class="text-sm text-blue-400 font-medium line-clamp-1"
                               x-text="metaTitle || title || 'Título do artigo'"></p>
                            <p class="text-xs text-zinc-400 line-clamp-2"
                               x-text="metaDesc || excerpt || 'Descrição do artigo aparece aqui…'"></p>
                        </div>
                    </div>

                </div>
            </div>

            {{-- ── Card Imagem Destaque ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5">
                    <h3 class="text-sm font-semibold text-white">Imagem Destaque</h3>
                </div>
                <div class="p-5 space-y-4">
                    <input type="hidden" name="featured_image" x-model="featuredImage">

                    {{-- Preview --}}
                    <div x-show="featuredImage" class="rounded-lg overflow-hidden bg-zinc-800 aspect-video">
                        <img :src="featuredImage" alt="Featured image" class="w-full h-full object-cover">
                    </div>

                    {{-- Upload zone --}}
                    <div
                        x-data="imageUploader('featured_image', url => { featuredImage = url; })"
                        class="relative border-2 border-dashed rounded-lg transition-colors cursor-pointer"
                        :class="dragging ? 'border-violet-500 bg-violet-500/5' : 'border-zinc-700 hover:border-zinc-600'"
                        @dragover.prevent="dragging = true"
                        @dragleave="dragging = false"
                        @drop.prevent="handleDrop($event)"
                        @click="$refs.fileInput.click()"
                    >
                        <div class="px-4 py-6 text-center pointer-events-none">
                            <template x-if="!uploading">
                                <div>
                                    <svg class="w-8 h-8 text-zinc-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/></svg>
                                    <p class="text-xs text-zinc-500">Arrasta ou clica para fazer upload</p>
                                    <p class="text-[10px] text-zinc-600 mt-1">JPG, PNG ou WebP · máx. 2MB</p>
                                </div>
                            </template>
                            <template x-if="uploading">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="w-6 h-6 text-violet-400 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                    <p class="text-xs text-zinc-500">A fazer upload…</p>
                                </div>
                            </template>
                        </div>
                        <input type="file" x-ref="fileInput" class="hidden" accept="image/jpeg,image/png,image/webp"
                               @change="handleFile($event.target.files[0])">
                    </div>

                    @if($isEdit && $post->featured_image)
                    <button type="button" @click="featuredImage = ''"
                            class="text-xs text-red-400 hover:text-red-300 transition-colors">
                        Remover imagem
                    </button>
                    @endif

                    {{-- OG Image --}}
                    <div class="pt-2 border-t border-zinc-800/60">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Imagem OG <span class="font-normal text-zinc-600">(opcional)</span></label>
                        </div>
                        <input type="hidden" name="og_image" x-model="ogImage">
                        <div
                            x-data="imageUploader('og_image', url => { ogImage = url; })"
                            class="relative border-2 border-dashed rounded-lg cursor-pointer transition-colors"
                            :class="dragging ? 'border-violet-500 bg-violet-500/5' : 'border-zinc-800 hover:border-zinc-700'"
                            @dragover.prevent="dragging = true"
                            @dragleave="dragging = false"
                            @drop.prevent="handleDrop($event)"
                            @click="$refs.fileInput.click()"
                        >
                            <div class="px-3 py-4 text-center pointer-events-none">
                                <template x-if="!uploading && !ogImage">
                                    <p class="text-[10px] text-zinc-600">Imagem para redes sociais (1200×630)</p>
                                </template>
                                <template x-if="ogImage">
                                    <img :src="ogImage" alt="OG image" class="w-full h-16 object-cover rounded">
                                </template>
                                <template x-if="uploading">
                                    <svg class="w-5 h-5 text-violet-400 animate-spin mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </template>
                            </div>
                            <input type="file" x-ref="fileInput" class="hidden" accept="image/jpeg,image/png,image/webp"
                                   @change="handleFile($event.target.files[0])">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── Card Categoria ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
                    <h3 class="text-sm font-semibold text-white">Categoria</h3>
                    <button type="button" @click="categoryModalOpen = true"
                            class="w-6 h-6 rounded flex items-center justify-center text-zinc-500 hover:text-violet-400 hover:bg-violet-500/10 transition-colors"
                            title="Nova categoria">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                    </button>
                </div>
                <div class="p-5">
                    <select id="category_id" name="category_id"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                   focus:outline-none focus:border-violet-500/60 transition-colors appearance-none">
                        <option value="">— Selecionar —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $currentCat) == $cat->id)>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- ── Card Tags ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5">
                    <h3 class="text-sm font-semibold text-white">Tags</h3>
                </div>
                <div class="p-5">
                    {{-- Hidden inputs --}}
                    <template x-for="tagId in selectedTags" :key="tagId">
                        <input type="hidden" name="tags[]" :value="tagId">
                    </template>

                    {{-- Selected badges --}}
                    <div class="flex flex-wrap gap-1.5 mb-3" x-show="selectedTags.length > 0">
                        <template x-for="tagId in selectedTags" :key="tagId">
                            <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-violet-500/15 text-violet-300 border border-violet-500/30">
                                <span x-text="tagName(tagId)"></span>
                                <button type="button" @click="removeTag(tagId)" class="hover:text-red-400 transition-colors">×</button>
                            </span>
                        </template>
                    </div>

                    {{-- Tag input with autocomplete --}}
                    <div class="relative" x-data>
                        <input
                            type="text"
                            x-model="tagInput"
                            placeholder="Pesquisar ou criar tag…"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                   placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
                            @keydown.enter.prevent="
                                const filtered = filteredTags();
                                if (filtered.length > 0) addTag(filtered[0].id, filtered[0].name);
                            "
                        >
                        {{-- Dropdown --}}
                        <div x-show="tagInput.length > 0 && filteredTags().length > 0"
                             class="absolute z-20 top-full left-0 right-0 mt-1 rounded-lg border border-zinc-700 bg-[#0F0A1A] shadow-xl overflow-hidden">
                            <template x-for="tag in filteredTags()" :key="tag.id">
                                <button type="button"
                                        @click="addTag(tag.id, tag.name); tagInput = ''"
                                        class="w-full px-3 py-2 text-left text-sm text-zinc-300 hover:bg-violet-500/10 hover:text-violet-300 transition-colors flex items-center justify-between">
                                    <span x-text="tag.name"></span>
                                    <span class="text-[10px] text-zinc-600" x-text="tag.posts_count + ' posts'"></span>
                                </button>
                            </template>
                        </div>
                    </div>
                    <p class="text-[10px] text-zinc-600 mt-2">Enter para adicionar a primeira sugestão</p>
                </div>
            </div>

            {{-- ── Card Autor ── --}}
            <div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden">
                <div class="px-5 py-4 border-b border-white/5">
                    <h3 class="text-sm font-semibold text-white">Autor</h3>
                </div>
                <div class="p-5">
                    <select name="author_id"
                            class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                   focus:outline-none focus:border-violet-500/60 transition-colors appearance-none">
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" @selected(old('author_id', $currentAuthor) == $author->id)>
                                {{ $author->name }} @if($author->role !== 'editor')({{ $author->role }})@endif
                            </option>
                        @endforeach
                    </select>
                    @error('author_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>
            </div>

        </div>
    </div>

    {{-- ══ Modal Nova Categoria ══════════════════════════════════ --}}
    <div x-show="categoryModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         @click.self="categoryModalOpen = false">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-sm rounded-2xl border border-zinc-800/60 bg-[#1A1225] p-6 shadow-2xl"
             @click.stop>
            <h3 class="text-base font-bold text-white mb-4">Nova Categoria</h3>
            <input type="text" x-model="newCatName" placeholder="Nome da categoria…"
                   @keydown.enter.prevent="createCategory()"
                   class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                          placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors mb-4">
            <div class="flex gap-3">
                <button type="button" @click="categoryModalOpen = false"
                        class="flex-1 py-2 rounded-lg text-sm text-zinc-400 border border-zinc-700 hover:border-zinc-500 transition-colors">
                    Cancelar
                </button>
                <button type="button" @click="createCategory()" :disabled="newCatSaving"
                        class="flex-1 py-2 rounded-lg text-sm font-semibold text-white disabled:opacity-50 transition-all"
                        style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
                    <span x-show="!newCatSaving">Criar</span>
                    <span x-show="newCatSaving">A criar…</span>
                </button>
            </div>
        </div>
    </div>

</form>

{{-- ══ JavaScript ══════════════════════════════════════════════ --}}

{{-- Tags data (injected for Alpine) --}}
<script>
const allTags = @json($tags->map(fn($t) => ['id' => $t->id, 'name' => $t->name, 'posts_count' => $t->posts_count ?? 0]));
</script>

{{-- Image uploader Alpine component --}}
<script>
function imageUploader(fieldName, onSuccess) {
    return {
        dragging: false,
        uploading: false,
        handleDrop(event) {
            this.dragging = false;
            const file = event.dataTransfer.files[0];
            if (file) this.handleFile(file);
        },
        async handleFile(file) {
            if (!file) return;
            if (!['image/jpeg','image/png','image/webp'].includes(file.type)) {
                alert('Formato inválido. Use JPG, PNG ou WebP.');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('A imagem não pode ter mais de 2MB.');
                return;
            }
            this.uploading = true;
            try {
                const form = new FormData();
                form.append('file', file);
                form.append('_token', document.querySelector('meta[name=csrf-token]').content);
                const res = await fetch('{{ route('admin.api.upload-image') }}', {
                    method: 'POST',
                    body: form,
                });
                const data = await res.json();
                if (data.location) {
                    onSuccess(data.location);
                } else {
                    alert('Erro ao fazer upload da imagem.');
                }
            } catch (e) {
                alert('Erro ao fazer upload da imagem.');
            } finally {
                this.uploading = false;
            }
        }
    };
}
</script>

{{-- TinyMCE (jsDelivr CDN — sem API key) --}}
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
tinymce.init({
    selector: '#post-content',
    base_url: 'https://cdn.jsdelivr.net/npm/tinymce@6.8.3',
    suffix: '.min',
    height: 560,
    menubar: false,
    branding: false,
    promotion: false,
    skin: 'oxide-dark',
    content_css: 'dark',
    plugins: [
        'lists', 'link', 'image', 'table', 'code', 'codesample',
        'fullscreen', 'wordcount', 'autoresize'
    ],
    autoresize_bottom_margin: 20,
    min_height: 400,
    toolbar: [
        'undo redo | formatselect | bold italic underline | forecolor',
        'alignleft aligncenter alignright | bullist numlist | blockquote | link image | table codesample | code fullscreen'
    ],
    formats: {
        formatselect_items: [
            { title: 'Parágrafo', format: 'p' },
            { title: 'Título 2', format: 'h2' },
            { title: 'Título 3', format: 'h3' },
            { title: 'Título 4', format: 'h4' },
        ]
    },
    block_formats: 'Parágrafo=p; Título 2=h2; Título 3=h3; Título 4=h4; Pré-formatado=pre',
    codesample_languages: [
        { text: 'HTML/XML', value: 'markup' },
        { text: 'JavaScript', value: 'javascript' },
        { text: 'PHP', value: 'php' },
        { text: 'CSS', value: 'css' },
        { text: 'Bash', value: 'bash' },
    ],
    images_upload_url: '{{ route('admin.api.upload-image') }}',
    images_upload_handler: async (blobInfo) => {
        const form = new FormData();
        form.append('file', blobInfo.blob(), blobInfo.filename());
        form.append('_token', document.querySelector('meta[name=csrf-token]').content);
        const res = await fetch('{{ route('admin.api.upload-image') }}', { method: 'POST', body: form });
        const data = await res.json();
        if (!data.location) throw new Error('Upload falhou');
        return data.location;
    },
    setup(editor) {
        editor.on('change input', () => editor.save());
    }
});
</script>
