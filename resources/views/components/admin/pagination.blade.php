@props(['items'])

@if($items->hasPages())
<div class="flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">

    <p class="text-xs text-zinc-500">
        Mostrando
        <span class="font-medium text-zinc-300">{{ $items->firstItem() }}–{{ $items->lastItem() }}</span>
        de <span class="font-medium text-zinc-300">{{ $items->total() }}</span> resultados
    </p>

    <div class="flex items-center gap-1">

        {{-- Anterior --}}
        @if($items->onFirstPage())
            <span class="px-3 py-1.5 rounded-lg text-xs text-zinc-600 border border-zinc-800 cursor-not-allowed select-none">
                ← Anterior
            </span>
        @else
            <a
                href="{{ $items->previousPageUrl() }}"
                class="px-3 py-1.5 rounded-lg text-xs text-zinc-400 border border-zinc-700
                       hover:border-violet-500/40 hover:text-violet-400 transition-colors"
            >
                ← Anterior
            </a>
        @endif

        {{-- Página atual --}}
        <span class="px-3 py-1.5 text-xs text-zinc-500">
            {{ $items->currentPage() }} / {{ $items->lastPage() }}
        </span>

        {{-- Próximo --}}
        @if($items->hasMorePages())
            <a
                href="{{ $items->nextPageUrl() }}"
                class="px-3 py-1.5 rounded-lg text-xs text-zinc-400 border border-zinc-700
                       hover:border-violet-500/40 hover:text-violet-400 transition-colors"
            >
                Próximo →
            </a>
        @else
            <span class="px-3 py-1.5 rounded-lg text-xs text-zinc-600 border border-zinc-800 cursor-not-allowed select-none">
                Próximo →
            </span>
        @endif

    </div>
</div>
@endif
