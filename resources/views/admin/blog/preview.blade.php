@extends('layouts.app')

@section('title', 'Preview: ' . $post->title)

@section('content')

{{-- ── Admin Preview Banner ── --}}
<div class="fixed top-0 left-0 right-0 z-[9999] bg-amber-500 text-amber-950 py-2.5 px-4 flex items-center justify-between gap-4 shadow-lg">
    <div class="flex items-center gap-3">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span class="text-sm font-semibold">Preview</span>
        <span class="text-sm hidden sm:inline">— Este artigo ainda não está publicado</span>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.blog.edit', $post) }}"
           class="px-3 py-1 rounded-md text-xs font-medium bg-amber-900/20 hover:bg-amber-900/40 transition-colors">
            Editar
        </a>
        <button
            type="button"
            id="publish-btn"
            onclick="publishPost()"
            class="px-3 py-1 rounded-md text-xs font-bold bg-amber-950 text-amber-400 hover:bg-amber-900 transition-colors">
            Publicar agora
        </button>
        <a href="{{ route('admin.blog.index') }}"
           class="px-3 py-1 rounded-md text-xs font-medium bg-amber-900/20 hover:bg-amber-900/40 transition-colors">
            ← Blog admin
        </a>
    </div>
</div>

{{-- Spacer for fixed banner --}}
<div class="h-10"></div>

@php
    use Illuminate\Support\Str;

    $categoryColors = [
        'web-design'        => 'bg-blue-500/15 text-blue-300',
        'seo'               => 'bg-emerald-500/15 text-emerald-300',
        'marketing-digital' => 'bg-amber-500/15 text-amber-300',
        'tecnologia'        => 'bg-violet-500/15 text-violet-300',
        'tutoriais'         => 'bg-rose-500/15 text-rose-300',
    ];
    $catColor = $categoryColors[$post->category->slug ?? ''] ?? 'bg-zinc-700/60 text-zinc-300';

    // Process content for headings
    $content = $post->content;
    $ids = [];
    $contentWithIds = preg_replace_callback(
        '/<(h[23])([^>]*)>(.*?)<\/h[23]>/is',
        function ($m) use (&$ids) {
            if (str_contains($m[2], 'id=')) return $m[0];
            $text   = strip_tags($m[3]);
            $baseId = Str::slug($text);
            $id     = $baseId;
            $n      = 1;
            while (in_array($id, $ids)) {
                $id = $baseId . '-' . $n++;
            }
            $ids[] = $id;
            return "<{$m[1]}{$m[2]} id=\"{$id}\">{$m[3]}</{$m[1]}>";
        },
        $content
    );
@endphp

{{-- Article header --}}
<section class="pt-20 pb-8 px-4 bg-[#0A0612]">
    <div class="max-w-4xl mx-auto">
        <nav class="flex items-center gap-1.5 text-xs text-zinc-500 mb-6">
            <a href="{{ route('blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
            <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="hover:text-violet-400 transition-colors">{{ $post->category->name }}</a>
                <svg class="w-3 h-3 text-zinc-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
            @endif
            <span class="text-zinc-400 truncate max-w-[200px]">{{ $post->title }}</span>
        </nav>

        @if($post->category)
            <span class="inline-flex text-[10px] font-bold px-2.5 py-1 rounded-full mb-4 {{ $catColor }}">
                {{ $post->category->name }}
            </span>
        @endif

        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-6">
            {{ $post->title }}
        </h1>

        <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-400 mb-8">
            @if($post->author)
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold text-white"
                     style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                    {{ mb_substr($post->author->name, 0, 1) }}
                </div>
                <span>{{ $post->author->name }}</span>
            </div>
            <span class="text-zinc-700">·</span>
            @endif
            <span>{{ ($post->published_at ?? now())->format('d M Y') }}</span>
            <span class="text-zinc-700">·</span>
            <span>{{ $post->reading_time }} min leitura</span>
        </div>

        @if($post->featured_image)
        <div class="rounded-2xl overflow-hidden aspect-video mb-8">
            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
        </div>
        @endif
    </div>
</section>

{{-- Article content --}}
<section class="bg-[#0A0612] px-4 pb-20">
    <div class="max-w-4xl mx-auto">
        <article class="prose prose-blog prose-base max-w-none" id="article-content">
            {!! $contentWithIds !!}
        </article>

        {{-- Tags --}}
        @if($post->tags->isNotEmpty())
        <div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-zinc-800/60">
            @foreach($post->tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}"
                   class="text-xs px-2.5 py-1 rounded-full border border-zinc-700 text-zinc-500 hover:border-violet-500/40 hover:text-violet-400 transition-all">
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
async function publishPost() {
    const btn = document.getElementById('publish-btn');
    btn.disabled = true;
    btn.textContent = 'A publicar…';
    const res = await fetch('{{ route('admin.blog.togglePublish', $post) }}', {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
            'Accept': 'application/json'
        }
    });
    const data = await res.json();
    if (data.ok && data.is_published) {
        window.location.href = '{{ route('blog.show', $post->slug) }}';
    } else {
        btn.disabled = false;
        btn.textContent = 'Publicar agora';
    }
}
</script>
@endpush
