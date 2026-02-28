@props(['href' => '#', 'variant' => 'primary'])
@php
$classes = match($variant) {
    'primary' => 'bg-[var(--accent)] text-white hover:bg-[var(--accent-light)]',
    'outline' => 'border border-white/30 text-white hover:bg-white/10',
    'white' => 'bg-[var(--white)] text-[var(--black)] hover:bg-white',
    default => 'bg-[var(--accent)] text-white hover:bg-[var(--accent-light)]',
};
@endphp
<a href="{{ $href }}" data-magnetic {{ $attributes->merge(['class' => "$classes inline-flex items-center gap-2 px-8 py-4 rounded-full font-medium transition-colors duration-300"]) }}>
    {{ $slot }}
</a>
