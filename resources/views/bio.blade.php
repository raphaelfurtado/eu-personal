@php
    // Iniciais para o avatar quando não houver foto
    $initials = collect(explode(' ', trim($trainer->name)))
        ->filter()->take(2)
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
        ->implode('');

    $photo = $trainer->bio_bg_image_url;
    $showBranding = ! $trainer->planAllows('remove_branding');

    if ($photo) {
        // Modo FOTO: escurece o fundo (scrim) e usa texto/elementos claros
        $pageBg      = "linear-gradient(180deg,rgba(0,0,0,.45),rgba(0,0,0,.58)),url('".e($photo)."') center/cover no-repeat";
        $nameColor   = '#ffffff';
        $subColor    = 'rgba(255,255,255,.88)';
        $taglineColor= 'rgba(255,255,255,.85)';
        $btnBg       = '#ffffff';
        $btnFg       = '#15211b';
        $ghostBg     = 'transparent';
        $ghostFg     = '#ffffff';
        $ghostBorder = 'rgba(255,255,255,.55)';
        $avatarBorder= 'rgba(255,255,255,.9)';
        $socialColor = '#ffffff';
        $footFg      = 'rgba(255,255,255,.8)';
        $nameShadow  = '0 1px 12px rgba(0,0,0,.4)';
    } else {
        // Modo CLARO (sem foto): degradê suave da cor da marca + botões na cor da marca
        $pageBg      = 'linear-gradient(180deg,var(--brand-tint,#e8f0ea),var(--page,#f5f4ef) 320px)';
        $nameColor   = '#1b2520';
        $subColor    = 'var(--brand-2,#2f7d54)';
        $taglineColor= '#4a564f';
        $btnBg       = 'var(--brand,#1f4733)';
        $btnFg       = 'var(--on-brand,#fff)';
        $ghostBg     = '#ffffff';
        $ghostFg     = 'var(--brand,#1f4733)';
        $ghostBorder = '#e3e0d7';
        $avatarBorder= '#ffffff';
        $socialColor = 'var(--brand,#1f4733)';
        $footFg      = '#6b7670';
        $nameShadow  = 'none';
    }
@endphp

<x-layout :title="$trainer->name.' · '.$trainer->role" :theme-style="$trainer->theme_style" :alpine="false">
<main style="min-height:100vh;background:{{ $pageBg }};padding:clamp(40px,9vw,68px) 22px 44px;display:flex;flex-direction:column;align-items:center;">
    <div style="width:100%;max-width:480px;display:flex;flex-direction:column;align-items:center;text-align:center;">

        {{-- avatar --}}
        @if ($trainer->hero_photo_url)
            <img src="{{ $trainer->hero_photo_url }}" alt="{{ $trainer->name }}" style="width:108px;height:108px;border-radius:50%;object-fit:cover;border:3px solid {{ $avatarBorder }};box-shadow:0 10px 28px rgba(0,0,0,.18);">
        @else
            <div style="width:108px;height:108px;border-radius:50%;background:{{ $btnBg }};color:{{ $btnFg }};display:flex;align-items:center;justify-content:center;font:700 38px/1 'Oswald',sans-serif;border:3px solid {{ $avatarBorder }};box-shadow:0 10px 28px rgba(0,0,0,.18);">{{ $initials }}</div>
        @endif

        {{-- nome + bio curta --}}
        <h1 style="font:700 clamp(26px,6vw,32px)/1.05 'Oswald',sans-serif;letter-spacing:.4px;color:{{ $nameColor }};margin:18px 0 0;text-shadow:{{ $nameShadow }};">{{ $trainer->name }}</h1>
        <div style="display:inline-flex;align-items:center;gap:6px;margin-top:9px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:1.5px;text-transform:uppercase;color:{{ $subColor }};">
            @if ($trainer->verified)<x-icon name="check-fill" size="13" />@endif
            {{ $trainer->role }}@if($trainer->city) · {{ $trainer->city }}@endif
        </div>
        @if ($trainer->tagline)
            <p style="font:400 15px/1.5 'Inter',sans-serif;color:{{ $taglineColor }};margin:14px 0 0;max-width:36ch;">{{ \Illuminate\Support\Str::limit($trainer->tagline, 120) }}</p>
        @endif

        {{-- botões --}}
        <div style="width:100%;display:flex;flex-direction:column;gap:13px;margin-top:30px;">
            <a href="{{ route('profile', $trainer) }}#contato" class="bio-btn" style="background:{{ $btnBg }};color:{{ $btnFg }};">
                <x-icon name="arrow-right" size="18" sw="2.4" /> Agendar avaliação
            </a>

            @if ($trainer->whatsapp)
                <a href="{{ $trainer->whatsapp_url }}" target="_blank" rel="noopener" class="bio-btn" style="background:{{ $btnBg }};color:{{ $btnFg }};">
                    <x-icon name="whatsapp" size="18" /> WhatsApp
                </a>
            @endif

            @foreach ($trainer->links as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener" class="bio-btn" style="background:{{ $btnBg }};color:{{ $btnFg }};">
                    <x-icon :name="$link->icon ?: 'link'" size="18" /> {{ $link->label }}
                </a>
            @endforeach

            <a href="{{ route('profile', $trainer) }}" class="bio-btn" style="background:{{ $ghostBg }};color:{{ $ghostFg }};border:1.5px solid {{ $ghostBorder }};box-shadow:none;">
                <x-icon name="arrow-ur" size="18" sw="2.2" /> Ver site completo
            </a>
        </div>

        {{-- redes sociais --}}
        @if (count($trainer->social_links))
            <div style="display:flex;justify-content:center;flex-wrap:wrap;gap:22px;margin-top:28px;">
                @foreach ($trainer->social_links as $s)
                    <a href="{{ $s['url'] }}" target="_blank" rel="noopener" aria-label="{{ $s['icon'] }}" style="color:{{ $socialColor }};opacity:.9;display:inline-flex;"><x-icon :name="$s['icon']" size="22" /></a>
                @endforeach
            </div>
        @endif

        {{-- rodapé PersonalBio (só no plano Grátis) --}}
        @if ($showBranding)
            <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:7px;margin-top:34px;text-decoration:none;opacity:.85;">
                <span style="width:24px;height:24px;border-radius:7px;background:#1f4733;display:flex;align-items:center;justify-content:center;color:var(--accent,#d8a32e);"><x-icon name="logo" size="14" sw="2.4" /></span>
                <span style="font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:{{ $footFg }};">Feito com PersonalBio</span>
            </a>
        @endif
    </div>
</main>
</x-layout>
