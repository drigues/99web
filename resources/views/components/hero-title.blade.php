@props(['lines' => []])
<h1 {{ $attributes->merge(['class' => 'font-display']) }}>
    @foreach($lines as $line)
        <span class="line block overflow-hidden">
            <span class="line-inner block">{!! $line !!}</span>
        </span>
    @endforeach
</h1>
