@props(['class' => ''])

<div class="rounded-xl border border-zinc-800/60 bg-[#1A1225] overflow-hidden {{ $class }}">

    @isset($header)
        <div class="flex items-center justify-between px-6 py-4 border-b border-white/5 gap-4">
            {{ $header }}
        </div>
    @endisset

    <div class="overflow-x-auto">
        <table class="w-full text-sm" role="table">
            {{ $slot }}
        </table>
    </div>

    @isset($footer)
        <div class="px-6 py-4 border-t border-white/5">
            {{ $footer }}
        </div>
    @endisset

</div>
