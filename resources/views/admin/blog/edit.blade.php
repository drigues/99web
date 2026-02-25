@extends('admin.layouts.admin')

@section('title', $post->title)

@section('breadcrumb')
    <a href="{{ route('admin.blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
    <span class="text-zinc-700 mx-1.5">/</span>
    <span class="truncate max-w-[200px]">{{ $post->title }}</span>
@endsection

@section('content')

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <div class="flex items-center gap-3 min-w-0">
            <a href="{{ route('admin.blog.index') }}"
               class="w-8 h-8 rounded-lg flex items-center justify-center text-zinc-500 hover:text-white hover:bg-zinc-800/60 transition-colors flex-shrink-0">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
            </a>
            <div class="min-w-0">
                <h1 class="text-xl font-bold text-white truncate">{{ $post->title }}</h1>
                <p class="text-sm text-zinc-500 mt-0.5">
                    Editado {{ $post->updated_at->diffForHumans() }}
                    · {{ number_format($post->views_count) }} visualizações
                </p>
            </div>
        </div>

        {{-- Quick actions --}}
        <div class="flex items-center gap-2 flex-shrink-0">
            @if($post->is_published)
            <a href="{{ route('blog.show', $post->slug) }}" target="_blank"
               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-zinc-400 border border-zinc-700 hover:border-zinc-500 hover:text-white transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                Ver no site
            </a>
            @endif

            <form method="POST" action="{{ route('admin.blog.destroy', $post) }}"
                  x-data @submit.prevent="if(confirm('Eliminar «{{ addslashes($post->title) }}»?')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs text-zinc-500 border border-zinc-800 hover:border-red-500/40 hover:text-red-400 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/></svg>
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    @include('admin.blog._partials.post-form')

</div>

@endsection
