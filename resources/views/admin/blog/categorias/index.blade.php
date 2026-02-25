@extends('admin.layouts.admin')

@section('title', 'Categorias do Blog')

@section('breadcrumb')
    <a href="{{ route('admin.blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
    <span class="text-zinc-700 mx-1.5">/</span>
    <span>Categorias</span>
@endsection

@section('content')

<div
    class="space-y-5"
    x-data="{
        categories: @js($categories),
        createModalOpen: false,
        editModalOpen: false,
        editTarget: null,
        form: { name: '', description: '', meta_title: '', meta_description: '' },
        saving: false,
        error: '',

        openCreate() {
            this.form = { name: '', description: '', meta_title: '', meta_description: '' };
            this.error = '';
            this.createModalOpen = true;
        },

        openEdit(cat) {
            this.editTarget = cat;
            this.form = {
                name: cat.name,
                description: cat.description ?? '',
                meta_title: cat.meta_title ?? '',
                meta_description: cat.meta_description ?? '',
            };
            this.error = '';
            this.editModalOpen = true;
        },

        async createCategory() {
            this.saving = true;
            this.error = '';
            try {
                const res = await fetch('{{ route('admin.blog.categorias.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                if (data.ok) {
                    this.categories.push(data.category);
                    this.createModalOpen = false;
                } else {
                    this.error = data.error ?? 'Erro ao criar categoria.';
                }
            } catch {
                this.error = 'Erro de rede. Tenta novamente.';
            } finally {
                this.saving = false;
            }
        },

        async updateCategory() {
            this.saving = true;
            this.error = '';
            try {
                const res = await fetch(`{{ url('/admin/blog/categorias') }}/${this.editTarget.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(this.form),
                });
                const data = await res.json();
                if (data.ok) {
                    const idx = this.categories.findIndex(c => c.id === this.editTarget.id);
                    if (idx > -1) this.categories[idx] = data.category;
                    this.editModalOpen = false;
                } else {
                    this.error = data.error ?? 'Erro ao atualizar categoria.';
                }
            } catch {
                this.error = 'Erro de rede. Tenta novamente.';
            } finally {
                this.saving = false;
            }
        },

        async deleteCategory(cat) {
            if (!confirm('Eliminar a categoria «' + cat.name + '»?')) return;
            const res = await fetch(`{{ url('/admin/blog/categorias') }}/${cat.id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
            });
            const data = await res.json();
            if (data.ok) {
                this.categories = this.categories.filter(c => c.id !== cat.id);
            } else {
                alert(data.error ?? 'Não foi possível eliminar a categoria.');
            }
        }
    }"
    @keydown.escape="createModalOpen = false; editModalOpen = false"
>

    {{-- ── Header ── --}}
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-bold text-white">Categorias do Blog</h1>
            <p class="text-sm text-zinc-500 mt-0.5" x-text="categories.length + ' categorias'"></p>
        </div>
        <button type="button" @click="openCreate()"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all"
                style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Nova Categoria
        </button>
    </div>

    {{-- ── Tabela ── --}}
    <x-admin.table>
        <x-slot:header>
            <span class="text-sm font-semibold text-white">Categorias</span>
            <span class="text-xs text-zinc-500" x-text="categories.length + ' total'"></span>
        </x-slot:header>

        <thead>
            <tr class="border-b border-white/5">
                <th class="w-10 px-4 py-3 text-center">
                    <svg class="w-4 h-4 text-zinc-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
                </th>
                <th class="px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Nome / Slug</th>
                <th class="hidden md:table-cell px-4 py-3 text-left text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Descrição</th>
                <th class="px-4 py-3 text-center text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Posts</th>
                <th class="px-4 py-3 text-right text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>

        <tbody id="sortable-categories" class="divide-y divide-white/5">
            <template x-for="cat in categories" :key="cat.id">
                <tr class="hover:bg-white/[0.02] transition-colors" :data-id="cat.id">
                    {{-- Drag handle --}}
                    <td class="px-4 py-3 text-center cursor-grab drag-handle">
                        <svg class="w-4 h-4 text-zinc-600 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5"/></svg>
                    </td>

                    {{-- Nome / Slug --}}
                    <td class="px-4 py-3">
                        <p class="text-sm font-medium text-white" x-text="cat.name"></p>
                        <p class="text-[11px] text-zinc-500 mt-0.5" x-text="cat.slug"></p>
                    </td>

                    {{-- Descrição --}}
                    <td class="hidden md:table-cell px-4 py-3">
                        <p class="text-xs text-zinc-400 line-clamp-2" x-text="cat.description || '—'"></p>
                    </td>

                    {{-- Posts count --}}
                    <td class="px-4 py-3 text-center">
                        <span class="text-sm font-medium text-zinc-300" x-text="cat.posts_count ?? 0"></span>
                    </td>

                    {{-- Ações --}}
                    <td class="px-4 py-3">
                        <div class="flex items-center justify-end gap-1">
                            <button type="button" @click="openEdit(cat)"
                                    class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-500 hover:text-violet-400 hover:bg-violet-500/10 transition-colors"
                                    title="Editar">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"/></svg>
                            </button>
                            <button type="button" @click="deleteCategory(cat)"
                                    class="w-7 h-7 rounded-md flex items-center justify-center text-zinc-600 hover:text-red-400 hover:bg-red-500/10 transition-colors"
                                    title="Eliminar"
                                    :disabled="(cat.posts_count ?? 0) > 0"
                                    :class="(cat.posts_count ?? 0) > 0 ? 'opacity-30 cursor-not-allowed' : ''">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
            </template>

            {{-- Empty state (shown via x-if) --}}
            <template x-if="categories.length === 0">
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center">
                        <p class="text-sm text-zinc-500">Nenhuma categoria criada ainda.</p>
                        <button type="button" @click="openCreate()"
                                class="inline-block mt-3 text-xs text-violet-400 hover:underline">
                            Criar primeira categoria →
                        </button>
                    </td>
                </tr>
            </template>
        </tbody>
    </x-admin.table>

    <p class="text-xs text-zinc-600 text-center">Arrasta as linhas para reordenar as categorias</p>

    {{-- ══ Modal Criar ══════════════════════════════════════════ --}}
    <div x-show="createModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         @click.self="createModalOpen = false">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg rounded-2xl border border-zinc-800/60 bg-[#1A1225] p-6 shadow-2xl"
             @click.stop>

            <h3 class="text-lg font-bold text-white mb-5">Nova Categoria</h3>

            <div x-show="error" class="mb-4 rounded-lg bg-red-500/10 border border-red-500/20 px-4 py-3">
                <p class="text-xs text-red-400" x-text="error"></p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Nome *</label>
                    <input type="text" x-model="form.name" placeholder="Nome da categoria…"
                           @keydown.enter.prevent="createCategory()"
                           class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                  placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Descrição</label>
                    <textarea x-model="form.description" rows="2" placeholder="Breve descrição da categoria…"
                              class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                     placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Meta Título <span class="font-normal text-zinc-600">(60 chars)</span></label>
                        <input type="text" x-model="form.meta_title" maxlength="60"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Meta Descrição <span class="font-normal text-zinc-600">(160)</span></label>
                        <input type="text" x-model="form.meta_description" maxlength="160"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" @click="createModalOpen = false"
                        class="flex-1 py-2.5 rounded-lg text-sm text-zinc-400 border border-zinc-700 hover:border-zinc-500 transition-colors">
                    Cancelar
                </button>
                <button type="button" @click="createCategory()" :disabled="saving || !form.name.trim()"
                        class="flex-1 py-2.5 rounded-lg text-sm font-semibold text-white disabled:opacity-50 transition-all"
                        style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
                    <span x-show="!saving">Criar Categoria</span>
                    <span x-show="saving">A criar…</span>
                </button>
            </div>
        </div>
    </div>

    {{-- ══ Modal Editar ══════════════════════════════════════════ --}}
    <div x-show="editModalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center px-4"
         @click.self="editModalOpen = false">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm"></div>
        <div class="relative w-full max-w-lg rounded-2xl border border-zinc-800/60 bg-[#1A1225] p-6 shadow-2xl"
             @click.stop>

            <h3 class="text-lg font-bold text-white mb-5">Editar Categoria</h3>

            <div x-show="error" class="mb-4 rounded-lg bg-red-500/10 border border-red-500/20 px-4 py-3">
                <p class="text-xs text-red-400" x-text="error"></p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Nome *</label>
                    <input type="text" x-model="form.name"
                           class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                  placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Descrição</label>
                    <textarea x-model="form.description" rows="2"
                              class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                     placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors resize-none"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Meta Título</label>
                        <input type="text" x-model="form.meta_title" maxlength="60"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1.5">Meta Descrição</label>
                        <input type="text" x-model="form.meta_description" maxlength="160"
                               class="w-full px-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                                      placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors">
                    </div>
                </div>
                <div x-show="editTarget?.slug">
                    <label class="block text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Slug atual</label>
                    <p class="text-xs text-zinc-500 font-mono" x-text="editTarget?.slug"></p>
                </div>
            </div>

            <div class="flex gap-3 mt-6">
                <button type="button" @click="editModalOpen = false"
                        class="flex-1 py-2.5 rounded-lg text-sm text-zinc-400 border border-zinc-700 hover:border-zinc-500 transition-colors">
                    Cancelar
                </button>
                <button type="button" @click="updateCategory()" :disabled="saving || !form.name.trim()"
                        class="flex-1 py-2.5 rounded-lg text-sm font-semibold text-white disabled:opacity-50 transition-all"
                        style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);">
                    <span x-show="!saving">Guardar Alterações</span>
                    <span x-show="saving">A guardar…</span>
                </button>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
{{-- SortableJS para drag-and-drop reordering --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.3/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const el = document.getElementById('sortable-categories');
    if (!el) return;

    new Sortable(el, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: async () => {
            const rows = el.querySelectorAll('[data-id]');
            const items = [...rows].map((row, index) => ({
                id: parseInt(row.dataset.id),
                order: index,
            }));

            await fetch('{{ route('admin.blog.categorias.reorder') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ items }),
            });
        }
    });
});
</script>
@endpush
