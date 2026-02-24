@props(['title' => null, 'class' => ''])

<div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden {{ $class }}">
    @if($title)
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5">
            <h3 class="text-sm font-semibold text-white">{{ $title }}</h3>
            @isset($action)
                <div>{{ $action }}</div>
            @endisset
        </div>
    @endif
    {{ $slot }}
</div>
