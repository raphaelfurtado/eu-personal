@props([
    'links' => [],            // [['href'=>'#x','label'=>'X'], ...]
    'ctaHref' => '#',
    'ctaLabel' => 'Criar meu perfil',
    'home' => '/',
    'logoSrc' => null,        // logo enviado pelo personal
    'brand' => 'PersonalBio',     // wordmark
])
<header x-data="{ open: false }" style="position:sticky;top:0;z-index:60;">
    <div style="position:relative;background:var(--page,#f5f4ef);border-bottom:1px solid #e7e5dd;">
        <div style="max-width:1180px;margin:0 auto;padding:14px clamp(20px,5vw,24px);display:flex;align-items:center;gap:20px;">
            <x-logo :href="$home" :src="$logoSrc" :label="$brand" />
            <nav data-desktop-nav style="display:flex;align-items:center;gap:28px;margin-left:auto;">
                @foreach ($links as $l)
                    <a href="{{ $l['href'] }}" style="font:600 13px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#3a463f;text-decoration:none;">{{ $l['label'] }}</a>
                @endforeach
                <a href="{{ $ctaHref }}" style="padding:12px 22px;background:var(--brand,#1f4733);color:var(--on-brand,#fff);border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">{{ $ctaLabel }}</a>
            </nav>
            <button data-burger @click="open = !open" :aria-expanded="open" aria-label="Menu" style="display:none;margin-left:auto;width:44px;height:44px;align-items:center;justify-content:center;background:#fff;border:1px solid #e7e5dd;border-radius:11px;cursor:pointer;color:#1f4733;">
                <x-icon name="menu" size="22" sw="2.2" />
            </button>
        </div>

        {{-- dropdown mobile: painel flutuante, opaco e com sombra (não empurra/encobre mal o conteúdo) --}}
        <div x-show="open" x-cloak x-transition.opacity.duration.150ms @click.outside="open = false" @keydown.escape.window="open = false"
             style="position:absolute;left:0;right:0;top:100%;background:var(--page,#f5f4ef);border-bottom:1px solid #e7e5dd;box-shadow:0 18px 32px rgba(0,0,0,.14);display:flex;flex-direction:column;padding:8px clamp(20px,5vw,24px) 18px;z-index:60;">
            @foreach ($links as $l)
                <a href="{{ $l['href'] }}" @click="open = false" style="padding:14px 0;border-bottom:1px solid #e7e5dd;font:600 14px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#3a463f;text-decoration:none;">{{ $l['label'] }}</a>
            @endforeach
            <a href="{{ $ctaHref }}" @click="open = false" style="margin-top:14px;padding:14px;text-align:center;background:var(--brand,#1f4733);color:var(--on-brand,#fff);border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">{{ $ctaLabel }}</a>
        </div>
    </div>
</header>
