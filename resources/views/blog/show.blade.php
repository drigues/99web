@extends('layouts.app')

@php
$categoryColors = [
    'web-design'        => 'bg-blue-500/15 text-blue-300',
    'seo'               => 'bg-emerald-500/15 text-emerald-300',
    'marketing-digital' => 'bg-amber-500/15 text-amber-300',
    'tecnologia'        => 'bg-violet-500/15 text-violet-300',
    'tutoriais'         => 'bg-rose-500/15 text-rose-300',
];
$catColor = $categoryColors[$post->category->slug ?? ''] ?? 'bg-zinc-700/60 text-zinc-300';
@endphp

@section('content')

{{-- ── Article header ──────────────────────────────────────── --}}
<div class="pt-20 pb-8 px-4 bg-[#0A0612]">
    <div class="max-w-4xl mx-auto">

        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-1.5 text-xs text-zinc-500 mb-6 flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-violet-400 transition-colors">Home</a>
            <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <a href="{{ route('blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
            @if($post->category)
                <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                </svg>
                <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-violet-400 transition-colors">
                    {{ $post->category->name }}
                </a>
            @endif
            <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="text-zinc-400 truncate max-w-[200px] sm:max-w-xs">{{ $post->title }}</span>
        </nav>

        {{-- Category badge --}}
        @if($post->category)
            <span class="inline-flex text-[10px] font-bold px-2.5 py-1 rounded-full mb-4 {{ $catColor }}">
                {{ $post->category->name }}
            </span>
        @endif

        {{-- Title --}}
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white leading-tight mb-5">
            {{ $post->title }}
        </h1>

        {{-- Meta --}}
        <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500 pb-6 border-b border-zinc-800/60">

            {{-- Author --}}
            <div class="flex items-center gap-2">
                @if($post->author?->avatar)
                    <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}"
                         class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white"
                         style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                        {{ mb_substr($post->author->name ?? '9', 0, 1) }}
                    </div>
                @endif
                <span class="font-medium text-zinc-300">{{ $post->author->name ?? '99web' }}</span>
            </div>

            <span class="text-zinc-700">·</span>

            {{-- Date --}}
            <time datetime="{{ $post->published_at->toDateString() }}">
                {{ $post->published_at->locale('pt')->isoFormat('D [de] MMMM [de] YYYY') }}
            </time>

            <span class="text-zinc-700">·</span>

            {{-- Reading time --}}
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $post->reading_time }} min leitura
            </span>

            <span class="text-zinc-700">·</span>

            {{-- Views --}}
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                {{ number_format($post->views_count) }} visualizações
            </span>

        </div>

    </div>
</div>

{{-- ── Featured image ──────────────────────────────────────── --}}
@if($post->featured_image)
<div class="px-4 pb-8 bg-[#0A0612]">
    <div class="max-w-4xl mx-auto">
        <div class="aspect-video rounded-2xl overflow-hidden">
            <img
                src="{{ $post->featured_image }}"
                alt="{{ $post->title }}"
                class="w-full h-full object-cover"
            >
        </div>
    </div>
</div>
@endif

{{-- ── Article content + TOC ───────────────────────────────── --}}
<section class="px-4 pb-16 bg-[#0A0612]">
    <div class="max-w-6xl mx-auto">
        <div class="xl:grid xl:grid-cols-[1fr_220px] xl:gap-12 items-start">

            {{-- ── Article ── --}}
            <div class="max-w-3xl xl:max-w-none">

                {{-- Mobile TOC toggle --}}
                @if(!empty($toc))
                <div
                    x-data="{ open: false }"
                    class="xl:hidden mb-8 rounded-xl border border-zinc-800/60 bg-[#0F0A1A] overflow-hidden"
                >
                    <button
                        @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 text-sm font-semibold text-zinc-300
                               hover:text-white transition-colors"
                        :aria-expanded="open.toString()"
                    >
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                            </svg>
                            Índice do artigo
                        </span>
                        <svg class="w-4 h-4 text-zinc-500 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" x-cloak x-transition class="px-4 pb-4 border-t border-zinc-800/60">
                        <nav class="mt-3 space-y-0.5">
                            @foreach($toc as $item)
                                <a href="#{{ $item['id'] }}"
                                   @click="open = false"
                                   class="block py-1.5 text-sm text-zinc-400 hover:text-violet-400 transition-colors
                                          {{ $item['level'] === 'h3' ? 'pl-4 text-xs' : '' }}">
                                    {{ $item['text'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>
                @endif

                {{-- Article prose content --}}
                <article
                    id="article-content"
                    class="prose prose-blog prose-base lg:prose-lg max-w-none"
                >
                    {!! $contentWithIds !!}
                </article>

                {{-- Tags --}}
                @if($post->tags->isNotEmpty())
                <div class="flex flex-wrap items-center gap-2 mt-10 pt-8 border-t border-zinc-800/60">
                    <span class="text-xs font-bold text-zinc-500 uppercase tracking-wider mr-1">Tags:</span>
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}"
                           class="text-xs px-3 py-1 rounded-full border border-zinc-700 text-zinc-400
                                  hover:border-violet-500/40 hover:text-violet-400 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                {{-- Author box --}}
                <div class="mt-10 p-6 rounded-2xl border border-zinc-800/60 bg-[#0F0A1A]">
                    <div class="flex items-start gap-4">
                        @if($post->author?->avatar)
                            <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}"
                                 class="w-14 h-14 rounded-full object-cover flex-shrink-0">
                        @else
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-lg font-bold text-white flex-shrink-0"
                                 style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                                {{ mb_substr($post->author->name ?? '9', 0, 1) }}
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-1">Autor</p>
                            <p class="text-base font-bold text-white mb-1">{{ $post->author->name ?? '99web' }}</p>
                            <p class="text-sm text-zinc-400 leading-relaxed">
                                {{ $post->author->role ?? 'Equipa 99web' }} —
                                Especialista em soluções web modernas e estratégias digitais.
                            </p>
                            <a href="{{ route('blog.index') }}?autor={{ $post->author->id ?? '' }}"
                               class="inline-flex items-center gap-1 mt-3 text-xs text-violet-400 hover:text-violet-300 transition-colors font-medium">
                                Ver todos os artigos
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ── TOC sidebar (desktop) ── --}}
            @if(!empty($toc))
            <aside
                class="hidden xl:block sticky top-28"
                x-data="tocScrollSpy()"
                x-init="init()"
            >
                <div class="rounded-xl border border-zinc-800/60 bg-[#0F0A1A] p-5">
                    <p class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                        </svg>
                        Neste artigo
                    </p>
                    <nav class="space-y-0.5">
                        @foreach($toc as $item)
                            <a
                                href="#{{ $item['id'] }}"
                                :class="activeId === '{{ $item['id'] }}'
                                    ? 'text-violet-400 border-l-violet-500 font-medium'
                                    : 'text-zinc-500 border-l-transparent hover:text-zinc-300'"
                                class="block py-1.5 pl-3 border-l-2 text-sm transition-all
                                       {{ $item['level'] === 'h3' ? 'pl-5 text-xs' : '' }}"
                            >
                                {{ $item['text'] }}
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>
            @endif

        </div>
    </div>
</section>

{{-- ── Related posts ───────────────────────────────────────── --}}
@if($relatedPosts->isNotEmpty())
<section class="px-4 py-16 border-t border-zinc-800/60 bg-[#0F0A1A]">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-bold text-white mb-8">Artigos relacionados</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($relatedPosts as $post)
                @include('blog._partials.post-card', ['post' => $post, 'compact' => true])
            @endforeach
        </div>
    </div>
</section>
@endif

@push('scripts')
<script>
function tocScrollSpy() {
    return {
        activeId: '',
        observer: null,

        init() {
            const headings = document.querySelectorAll('#article-content h2[id], #article-content h3[id]');
            if (!headings.length) return;

            this.observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            this.activeId = entry.target.id;
                        }
                    });
                },
                {
                    rootMargin: '-15% 0px -70% 0px',
                    threshold: 0
                }
            );

            headings.forEach(h => this.observer.observe(h));
        }
    };
}
</script>
@endpush

@endsection
