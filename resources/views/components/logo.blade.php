@props([
    'variant' => 'header',  // header | footer
    'href' => '/',
    'src' => null,          // logo enviado (imagem); se ausente, usa o símbolo + texto
    'label' => 'PersonalBio',   // wordmark
])
@php
    $isFooter = $variant === 'footer';
    $box   = $isFooter ? 30 : 32;
    $radius= $isFooter ? 8 : 9;
    $boxBg = $isFooter ? 'rgba(255,255,255,.1)' : 'var(--brand,#1f4733)';
    $word  = $isFooter ? '#fff' : '#1b2520';
    $wordSize = $isFooter ? 20 : 22;
    $iconSize = $isFooter ? 17 : 19;
    $logoH = $isFooter ? 28 : 34;
@endphp
<a href="{{ $href }}" style="display:flex;align-items:center;gap:9px;text-decoration:none;">
    @if ($src)
        <img src="{{ $src }}" alt="{{ $label }}" style="height:{{ $logoH }}px;width:auto;max-width:170px;object-fit:contain;display:block;">
    @else
        <span style="width:{{ $box }}px;height:{{ $box }}px;border-radius:{{ $radius }}px;background:{{ $boxBg }};display:flex;align-items:center;justify-content:center;color:var(--accent,#d8a32e);">
            <x-icon name="logo" :size="$iconSize" sw="2.4" />
        </span>
        <span style="font:700 {{ $wordSize }}px/1 'Oswald',sans-serif;color:{{ $word }};letter-spacing:.3px;">{{ $label }}</span>
    @endif
</a>
