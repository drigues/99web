{{--
    Blog sidebar partial
    Variables: $categories, $tags, $activeCategorySlug (optional), $activeTagSlug (optional)
--}}

@php
$activeCategorySlug = $activeCategorySlug ?? null;
$activeTagSlug      = $activeTagSlug ?? null;
$totalPosts         = $categories->sum('posts_count');
@endphp

<div class="space-y-7">

    {{-- Search --}}
    <div>
        <h3 class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-3">Pesquisa</h3>
        <form method="GET" action="{{ route('blog.index') }}">
            <div class="relative">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Pesquisar artigos…"
                    class="w-full pl-9 pr-3 py-2 rounded-lg bg-white/5 border border-zinc-700 text-sm text-white
                           placeholder-zinc-600 focus:outline-none focus:border-violet-500/60 transition-colors"
                >
                <svg class="absolute left-2.5 top-2.5 w-4 h-4 text-zinc-500 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                </svg>
            </div>
        </form>
    </div>

    {{-- Categorias --}}
    <div>
        <h3 class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-3">Categorias</h3>
        <ul class="space-y-0.5">

            {{-- Todas --}}
            <li>
                <a href="{{ route('blog.index') }}"
                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all
                          {{ !$activeCategorySlug && !request()->routeIs('blog.category') && !$activeTagSlug
                              ? 'bg-violet-500/10 text-violet-300 font-medium'
                              : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50' }}">
                    <span>Todas</span>
                    <span class="text-xs text-zinc-600">{{ $totalPosts }}</span>
                </a>
            </li>

            @foreach($categories as $category)
            <li>
                <a href="{{ route('blog.category', $category->slug) }}"
                   class="flex items-center justify-between px-3 py-2 rounded-lg text-sm transition-all
                          {{ $activeCategorySlug === $category->slug || (request()->routeIs('blog.category') && request()->route('slug') === $category->slug)
                              ? 'bg-violet-500/10 text-violet-300 font-medium'
                              : 'text-zinc-400 hover:text-white hover:bg-zinc-800/50' }}">
                    <span>{{ $category->name }}</span>
                    <span class="text-xs text-zinc-600">{{ $category->posts_count }}</span>
                </a>
            </li>
            @endforeach

        </ul>
    </div>

    {{-- Tags --}}
    @if($tags->isNotEmpty())
    <div>
        <h3 class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider mb-3">Tags</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($tags as $tag)
                <a href="{{ route('blog.tag', $tag->slug) }}"
                   class="text-xs px-2.5 py-1 rounded-full border transition-all
                          {{ $activeTagSlug === $tag->slug || (request()->routeIs('blog.tag') && request()->route('slug') === $tag->slug)
                              ? 'border-violet-500/60 bg-violet-500/10 text-violet-300'
                              : 'border-zinc-700 text-zinc-500 hover:border-violet-500/40 hover:text-violet-400' }}">
                    {{ $tag->name }}
                    @if($tag->posts_count > 1)
                        <span class="text-zinc-600 ml-0.5">({{ $tag->posts_count }})</span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
    @endif

</div>
