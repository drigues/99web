{{--
    Post card component
    Variables: $post (BlogPost with category, author, tags relations)
    Optional: $compact (bool) for smaller cards
--}}
@php
$categoryColors = [
    'web-design'        => 'bg-blue-500/15 text-blue-300',
    'seo'               => 'bg-emerald-500/15 text-emerald-300',
    'marketing-digital' => 'bg-amber-500/15 text-amber-300',
    'tecnologia'        => 'bg-violet-500/15 text-violet-300',
    'tutoriais'         => 'bg-rose-500/15 text-rose-300',
];
$catColor = $categoryColors[$post->category->slug ?? ''] ?? 'bg-zinc-700/60 text-zinc-300';
$compact  = $compact ?? false;
@endphp

<article class="group rounded-2xl overflow-hidden border border-zinc-800/60 bg-[#0F0A1A]
                hover:-translate-y-0.5 hover:shadow-xl hover:shadow-violet-900/20 hover:border-zinc-700/60
                transition-all duration-300 flex flex-col">

    {{-- Image --}}
    <a href="{{ route('blog.show', $post->slug) }}" class="relative block aspect-video overflow-hidden flex-shrink-0">
        @if($post->featured_image)
            <img
                src="{{ $post->featured_image }}"
                alt="{{ $post->title }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                loading="lazy"
            >
        @else
            <div class="w-full h-full flex items-center justify-center"
                 style="background: linear-gradient(135deg, rgba(124,58,237,.18) 0%, rgba(15,10,26,.6) 100%);">
                <svg class="w-10 h-10 text-violet-500/40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
                </svg>
            </div>
        @endif

        {{-- Category badge --}}
        @if($post->category)
            <span class="absolute top-3 left-3 text-[10px] font-bold px-2.5 py-1 rounded-full {{ $catColor }} backdrop-blur-sm">
                {{ $post->category->name }}
            </span>
        @endif
    </a>

    {{-- Content --}}
    <div class="p-5 flex flex-col flex-1">

        <a href="{{ route('blog.show', $post->slug) }}" class="block mb-2">
            <h3 class="text-{{ $compact ? 'sm' : 'base' }} font-bold text-white leading-snug line-clamp-2
                        group-hover:text-violet-300 transition-colors">
                {{ $post->title }}
            </h3>
        </a>

        @if(!$compact)
            <p class="text-sm text-zinc-400 line-clamp-3 mb-4 flex-1">{{ $post->excerpt }}</p>
        @else
            <div class="flex-1"></div>
        @endif

        {{-- Footer --}}
        <div class="flex items-center gap-3 text-xs text-zinc-500 mt-auto pt-3 border-t border-zinc-800/60">

            {{-- Author avatar --}}
            <div class="flex items-center gap-1.5 min-w-0">
                @if($post->author?->avatar)
                    <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}"
                         class="w-5 h-5 rounded-full object-cover flex-shrink-0">
                @else
                    <div class="w-5 h-5 rounded-full flex items-center justify-center text-[9px] font-bold text-white flex-shrink-0"
                         style="background: linear-gradient(135deg, #7C3AED 0%, #9333EA 100%);">
                        {{ mb_substr($post->author->name ?? '9', 0, 1) }}
                    </div>
                @endif
                <span class="truncate">{{ $post->author->name ?? '99web' }}</span>
            </div>

            <span class="ml-auto flex-shrink-0">{{ $post->published_at->format('d M Y') }}</span>
            <span class="flex-shrink-0">· {{ $post->reading_time }} min</span>

        </div>
    </div>

</article>
