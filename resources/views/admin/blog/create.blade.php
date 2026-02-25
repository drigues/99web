@extends('admin.layouts.admin')

@section('title', 'Novo Artigo')

@section('breadcrumb')
    <a href="{{ route('admin.blog.index') }}" class="hover:text-violet-400 transition-colors">Blog</a>
    <span class="text-zinc-700 mx-1.5">/</span>
    <span>Novo Artigo</span>
@endsection

@section('content')

<div class="space-y-5">

    {{-- Header --}}
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.blog.index') }}"
           class="w-8 h-8 rounded-lg flex items-center justify-center text-zinc-500 hover:text-white hover:bg-zinc-800/60 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
        </a>
        <div>
            <h1 class="text-xl font-bold text-white">Novo Artigo</h1>
            <p class="text-sm text-zinc-500 mt-0.5">Cria e publica um novo artigo no blog</p>
        </div>
    </div>

    @include('admin.blog._partials.post-form')

</div>

@endsection
