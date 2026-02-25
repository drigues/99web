@extends('layouts.app')

@php
$categoryColors = [
    'web-design'        => 'bg-blue-500/15 text-blue-300',
    'seo'               => 'bg-emerald-500/15 text-emerald-300',
    'marketing-digital' => 'bg-amber-500/15 text-amber-300',
    'tecnologia'        => 'bg-violet-500/15 text-violet-300',
    'tutoriais'         => 'bg-rose-500/15 text-rose-300',
];
@endphp

@section('content')

{{-- ── Hero header ──────────────────────────────────────────── --}}
<section class="pt-24 pb-10 px-4 bg-[#0A0612]">
    <div class="max-w-6xl mx-auto">
        <div class="max-w-2xl">
            <p class="text-xs font-bold text-violet-400 uppercase tracking-widest mb-3">Blog</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3 leading-tight">
                Dicas, novidades e<br>
                <span style="background: linear-gradient(135deg, #A855F7 0%, #7C3AED 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                    tendências digitais
                </span>
            </h1>
            <p class="text-zinc-400 text-base">
                Insights da equipa 99web sobre web design, SEO, marketing digital e muito mais.
            </p>
        </div>
    </div>
</section>

{{-- ── Category filter bar ──────────────────────────────────── --}}
<div class="sticky top-16 z-10 bg-[#0A0612]/95 backdrop-blur-sm border-b border-zinc-800/60 px-4 py-0">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-1 overflow-x-auto scrollbar-hide py-3">

            <a href="{{ route('blog.index') }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-all
                      {{ !$activeCategorySlug && !$activeTagSlug && !request('search')
                          ? 'bg-violet-600 text-white'
                          : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60' }}">
                Todas
            </a>

            @foreach($categories as $category)
                <a href="{{ route('blog.category', $category->slug) }}"
                   class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-all
                          {{ $activeCategorySlug === $category->slug
                              ? 'bg-violet-600 text-white'
                              : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60' }}">
                    {{ $category->name }}
                    @if($category->posts_count > 0)
                        <span class="ml-1 text-[10px] opacity-60">{{ $category->posts_count }}</span>
                    @endif
                </a>
            @endforeach

            {{-- Mobile filter toggle --}}
            <button
                x-data
                @click="$dispatch('toggle-blog-filters')"
                class="ml-auto flex-shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm
                       text-zinc-400 hover:text-white border border-zinc-700 hover:border-zinc-500 transition-all lg:hidden"
            >
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 11-3 0m3 0a1.5 1.5 0 10-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m-9.75 0h9.75"/>
                </svg>
                Filtros
            </button>

        </div>
    </div>
</div>

{{-- ── Mobile filter panel (Alpine) ────────────────────────── --}}
<div
    x-data="{ open: false }"
    @toggle-blog-filters.window="open = !open"
    x-show="open"
    x-cloak
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 -translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 -translate-y-2"
    class="lg:hidden bg-[#0F0A1A] border-b border-zinc-800/60 px-4 py-5"
>
    <div class="max-w-6xl mx-auto">
        @include('blog._partials.sidebar', [
            'activeCategorySlug' => $activeCategorySlug,
            'activeTagSlug'      => $activeTagSlug,
        ])
    </div>
</div>

{{-- ── Active filter badge ───────────────────────────────────── --}}
@if($hasFilters)
<div class="bg-[#0A0612] px-4 py-3">
    <div class="max-w-6xl mx-auto flex flex-wrap items-center gap-2 text-sm text-zinc-500">
        <span>A mostrar resultados para:</span>
        @if(request('search'))
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-zinc-800/60 text-zinc-300 text-xs">
                "{{ request('search') }}"
                <a href="{{ request()->url() }}?{{ http_build_query(array_diff_key(request()->all(), ['search' => ''])) }}" class="hover:text-red-400 transition-colors" aria-label="Remover filtro">×</a>
            </span>
        @endif
        @if($activeCategorySlug)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-500/10 text-violet-300 text-xs">
                {{ $categories->firstWhere('slug', $activeCategorySlug)?->name ?? $activeCategorySlug }}
                <a href="{{ route('blog.index') }}" class="hover:text-red-400 transition-colors" aria-label="Remover filtro">×</a>
            </span>
        @endif
        @if($activeTagSlug)
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-zinc-800/60 text-zinc-300 text-xs">
                #{{ $activeTagSlug }}
                <a href="{{ route('blog.index') }}" class="hover:text-red-400 transition-colors" aria-label="Remover filtro">×</a>
            </span>
        @endif
        <a href="{{ route('blog.index') }}" class="ml-auto text-xs text-zinc-600 hover:text-zinc-400 transition-colors">
            Limpar filtros
        </a>
    </div>
</div>
@endif

{{-- ── Main content + sidebar ──────────────────────────────── --}}
<section class="bg-[#0A0612] px-4 pb-20 pt-8">
    <div class="max-w-6xl mx-auto">
        <div class="lg:grid lg:grid-cols-[1fr_260px] lg:gap-10 items-start">

            {{-- ── Posts column ── --}}
            <div>

                @if($posts->isEmpty())
                    {{-- Empty state --}}
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <div class="w-16 h-16 rounded-2xl bg-zinc-800/60 flex items-center justify-center mb-5">
                            <svg class="w-8 h-8 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                            </svg>
                        </div>
                        <h2 class="text-lg font-bold text-white mb-2">Nenhum artigo encontrado</h2>
                        <p class="text-sm text-zinc-500 mb-5">Tente ajustar os filtros ou termos de pesquisa.</p>
                        <a href="{{ route('blog.index') }}"
                           class="px-5 py-2 rounded-lg text-sm font-medium text-violet-400 border border-violet-500/30
                                  hover:bg-violet-500/10 transition-colors">
                            Ver todos os artigos
                        </a>
                    </div>

                @else

                    {{-- ── Featured post (first post, no filters) ─── --}}
                    @if($featuredPost)
                    @php $catColor = $categoryColors[$featuredPost->category->slug ?? ''] ?? 'bg-zinc-700/60 text-zinc-300'; @endphp
                    <article class="group mb-10 rounded-2xl overflow-hidden border border-zinc-800/60 bg-[#0F0A1A]
                                    hover:border-zinc-700/60 transition-all duration-300">
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="relative block aspect-video sm:aspect-[21/9] overflow-hidden">
                            @if($featuredPost->featured_image)
                                <img src="{{ $featuredPost->featured_image }}" alt="{{ $featuredPost->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                            @else
                                <div class="w-full h-full"
                                     style="background: linear-gradient(135deg, rgba(124,58,237,.25) 0%, rgba(15,10,26,.8) 100%);">
                                </div>
                            @endif
                            {{-- Gradient overlay --}}
                            <div class="absolute inset-0"
                                 style="background: linear-gradient(to top, rgba(15,10,26,.95) 0%, rgba(15,10,26,.3) 50%, transparent 100%);">
                            </div>
                            {{-- Content over image --}}
                            <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8">
                                @if($featuredPost->category)
                                    <span class="inline-flex text-[10px] font-bold px-2.5 py-1 rounded-full mb-3 {{ $catColor }}">
                                        {{ $featuredPost->category->name }}
                                    </span>
                                @endif
                                <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white leading-tight mb-3
                                           group-hover:text-violet-200 transition-colors line-clamp-2">
                                    {{ $featuredPost->title }}
                                </h2>
                                <p class="text-sm text-zinc-300 line-clamp-2 hidden sm:block mb-4">{{ $featuredPost->excerpt }}</p>
                                <div class="flex items-center gap-3 text-xs text-zinc-400">
                                    @if($featuredPost->author?->avatar)
                                        <img src="{{ $featuredPost->author->avatar }}" alt="{{ $featuredPost->author->name }}"
                                             class="w-6 h-6 rounded-full object-cover">
                                    @else
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold text-white"
                                             style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                                            {{ mb_substr($featuredPost->author->name ?? '9', 0, 1) }}
                                        </div>
                                    @endif
                                    <span>{{ $featuredPost->author->name ?? '99web' }}</span>
                                    <span>·</span>
                                    <span>{{ $featuredPost->published_at->format('d M Y') }}</span>
                                    <span>·</span>
                                    <span>{{ $featuredPost->reading_time }} min leitura</span>
                                </div>
                            </div>
                        </a>
                    </article>
                    @endif

                    {{-- ── Posts grid ── --}}
                    @if($remainingPosts->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($remainingPosts as $post)
                            @include('blog._partials.post-card', ['post' => $post])
                        @endforeach
                    </div>
                    @endif

                    {{-- ── Pagination ── --}}
                    @if($posts->hasPages())
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-10 pt-8 border-t border-zinc-800/60">

                        <p class="text-xs text-zinc-500">
                            Mostrando
                            <span class="text-zinc-300 font-medium">{{ $posts->firstItem() }}–{{ $posts->lastItem() }}</span>
                            de <span class="text-zinc-300 font-medium">{{ $posts->total() }}</span> artigos
                        </p>

                        <div class="flex items-center gap-1">
                            @if($posts->onFirstPage())
                                <span class="px-3 py-1.5 rounded-lg text-xs text-zinc-600 border border-zinc-800 cursor-not-allowed">← Anterior</span>
                            @else
                                <a href="{{ $posts->previousPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-zinc-400 border border-zinc-700 hover:border-violet-500/40 hover:text-violet-400 transition-colors">← Anterior</a>
                            @endif

                            <span class="px-3 py-1.5 text-xs text-zinc-500">{{ $posts->currentPage() }} / {{ $posts->lastPage() }}</span>

                            @if($posts->hasMorePages())
                                <a href="{{ $posts->nextPageUrl() }}" class="px-3 py-1.5 rounded-lg text-xs text-zinc-400 border border-zinc-700 hover:border-violet-500/40 hover:text-violet-400 transition-colors">Próximo →</a>
                            @else
                                <span class="px-3 py-1.5 rounded-lg text-xs text-zinc-600 border border-zinc-800 cursor-not-allowed">Próximo →</span>
                            @endif
                        </div>

                    </div>
                    @endif

                @endif

            </div>

            {{-- ── Sidebar (desktop) ── --}}
            <aside class="hidden lg:block sticky top-28">
                <div class="rounded-2xl border border-zinc-800/60 bg-[#0F0A1A] p-6">
                    @include('blog._partials.sidebar', [
                        'activeCategorySlug' => $activeCategorySlug,
                        'activeTagSlug'      => $activeTagSlug,
                    ])
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
