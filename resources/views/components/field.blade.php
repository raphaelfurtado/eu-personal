@props([
    'label' => null,
    'name',
    'value' => null,
    'type' => 'text',
    'placeholder' => '',
    'rows' => 3,
    'required' => false,
    'hint' => null,
])
@php
    $val = old($name, $value);
    $st = "width:100%;padding:13px 15px;border:1.5px solid #e0ddd3;border-radius:11px;font:400 15px 'Inter',sans-serif;color:#1b2520;background:#faf9f5;outline:none;";
@endphp
<div {{ $attributes->merge(['style' => 'margin-bottom:16px;']) }}>
    @if ($label)
        <label style="display:block;font:600 11px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;color:#6b7670;margin-bottom:7px;">{{ $label }}@if($required) <span style="color:#c0392b;">*</span>@endif</label>
    @endif
    @if ($type === 'textarea')
        <textarea name="{{ $name }}" rows="{{ $rows }}" placeholder="{{ $placeholder }}" @if($required) required @endif style="{{ $st }}resize:vertical;">{{ $val }}</textarea>
    @else
        <input name="{{ $name }}" type="{{ $type }}" value="{{ $val }}" placeholder="{{ $placeholder }}" @if($required) required @endif style="{{ $st }}">
    @endif
    @if ($hint)<div style="font:400 12px/1.4 'Inter',sans-serif;color:#8a9690;margin-top:5px;">{{ $hint }}</div>@endif
    @error($name)<div style="font:400 12px 'Inter',sans-serif;color:#c0392b;margin-top:5px;">{{ $message }}</div>@enderror
</div>
