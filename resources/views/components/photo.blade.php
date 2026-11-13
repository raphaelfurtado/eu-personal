@props([
    'src' => null,
    'label' => 'Foto',
    'radius' => 0,
])
<div {{ $attributes->merge(['style' => "border-radius:{$radius}px;overflow:hidden;background:#e8f0ea;"]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $label }}" style="width:100%;height:100%;object-fit:cover;display:block;">
    @else
        <div style="width:100%;height:100%;min-height:60px;display:flex;align-items:center;justify-content:center;color:#8aa394;font:600 12px/1.35 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;text-align:center;padding:12px;">{{ $label }}</div>
    @endif
</div>
