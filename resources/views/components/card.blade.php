@props([
    'title' => null,
    'desc' => null,
])
<section {{ $attributes->merge(['style' => 'background:#fff;border:1px solid #ece9e0;border-radius:20px;padding:clamp(22px,4vw,32px);margin-bottom:22px;']) }}>
    @if ($title)
        <h2 style="font:600 22px/1.2 'Oswald',sans-serif;letter-spacing:.3px;color:#1b2520;margin:0 0 {{ $desc ? '6px' : '20px' }};">{{ $title }}</h2>
    @endif
    @if ($desc)
        <p style="font:400 14px/1.55 'Inter',sans-serif;color:#6b7670;margin:0 0 20px;">{{ $desc }}</p>
    @endif
    {{ $slot }}
</section>
