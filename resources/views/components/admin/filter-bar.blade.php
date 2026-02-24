@props(['action' => ''])

<form
    method="GET"
    action="{{ $action }}"
    class="rounded-xl border border-zinc-800/60 bg-[#1A1225] p-4 mb-5 flex flex-wrap items-end gap-3"
>
    {{ $slot }}

    <div class="flex items-center gap-2 ml-auto">
        <button
            type="submit"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-sm font-medium text-white
                   transition-all duration-150 hover:shadow-md hover:shadow-violet-500/20"
            style="background: linear-gradient(135deg, #7C3AED 0%, #6D28D9 100%);"
        >
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
            </svg>
            Filtrar
        </button>

        @if(request()->hasAny(['search','status','source','package_type','meeting_type','date_from']))
            <a
                href="{{ $action }}"
                class="px-4 py-2 rounded-lg text-sm font-medium text-zinc-400 border border-zinc-700
                       hover:text-white hover:border-zinc-500 transition-colors"
            >
                Limpar
            </a>
        @endif
    </div>
</form>
