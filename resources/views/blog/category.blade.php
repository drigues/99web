@extends('layouts.app')

@section('content')

{{-- ── Header ──────────────────────────────────────────────── --}}
<section class="pt-24 pb-10 px-4 bg-[#0A0612]">
    <div class="max-w-6xl mx-auto">
        <nav class="flex items-center gap-1.5 text-xs text-zinc-500 mb-5" aria-label="Breadcrumb">
            <a href="{{ route('blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
            <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="text-zinc-400">{{ $category->name }}</span>
        </nav>
        <div class="max-w-2xl">
            <p class="text-xs font-bold text-violet-400 uppercase tracking-widest mb-3">Categoria</p>
            <h1 class="text-3xl sm:text-4xl font-bold text-white mb-3">{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-zinc-400 text-base">{{ $category->description }}</p>
            @else
                <p class="text-zinc-400 text-base">
                    {{ $posts->total() }} {{ $posts->total() === 1 ? 'artigo' : 'artigos' }} nesta categoria.
                </p>
            @endif
        </div>
    </div>
</section>

{{-- ── Category filter bar --}}
<div class="sticky top-16 z-10 bg-[#0A0612]/95 backdrop-blur-sm border-b border-zinc-800/60 px-4 py-0">
    <div class="max-w-6xl mx-auto">
        <div class="flex items-center gap-1 overflow-x-auto scrollbar-hide py-3">
            <a href="{{ route('blog.index') }}"
               class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-all
                      text-zinc-400 hover:text-white hover:bg-zinc-800/60">
                Todas
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('blog.category', $cat->slug) }}"
                   class="flex-shrink-0 px-4 py-1.5 rounded-full text-sm font-medium transition-all
                          {{ $cat->slug === $category->slug
                              ? 'bg-violet-600 text-white'
                              : 'text-zinc-400 hover:text-white hover:bg-zinc-800/60' }}">
                    {{ $cat->name }}
                    @if($cat->posts_count > 0)
                        <span class="ml-1 text-[10px] opacity-60">{{ $cat->posts_count }}</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Main content ──────────────────────────────────────────── --}}
<section class="bg-[#0A0612] px-4 pb-20 pt-8">
    <div class="max-w-6xl mx-auto">
        <div class="lg:grid lg:grid-cols-[1fr_260px] lg:gap-10 items-start">

            <div>
                @if($posts->isEmpty())
                    <div class="flex flex-col items-center justify-center py-24 text-center">
                        <p class="text-zinc-500 mb-4">Nenhum artigo nesta categoria ainda.</p>
                        <a href="{{ route('blog.index') }}"
                           class="px-5 py-2 rounded-lg text-sm font-medium text-violet-400 border border-violet-500/30 hover:bg-violet-500/10 transition-colors">
                            Ver todos os artigos
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach($posts as $post)
                            @include('blog._partials.post-card', ['post' => $post])
                        @endforeach
                    </div>

                    @if($posts->hasPages())
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mt-10 pt-8 border-t border-zinc-800/60">
                        <p class="text-xs text-zinc-500">
                            Mostrando <span class="text-zinc-300 font-medium">{{ $posts->firstItem() }}–{{ $posts->lastItem() }}</span>
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

            <aside class="hidden lg:block sticky top-28">
                <div class="rounded-2xl border border-zinc-800/60 bg-[#0F0A1A] p-6">
                    @include('blog._partials.sidebar', [
                        'activeCategorySlug' => $category->slug,
                        'activeTagSlug'      => null,
                    ])
                </div>
            </aside>

        </div>
    </div>
</section>

@endsection
