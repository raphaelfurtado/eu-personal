@props([
    'title' => 'Painel',
    'active' => 'index',     // index | profile | leads
])
@php
    $trainer = auth()->user()?->trainer;
    $nav = [
        'index'   => ['label' => 'Visão geral',   'href' => route('dashboard.index')],
        'profile' => ['label' => 'Editar perfil',  'href' => route('dashboard.profile.edit')],
        'leads'   => ['label' => 'Leads',          'href' => route('dashboard.leads')],
    ];
@endphp
<x-layout :title="$title.' · PersonalBio'">
<div style="min-height:100vh;background:#f5f4ef;">

    <header style="position:sticky;top:0;z-index:50;background:rgba(245,244,239,.92);backdrop-filter:blur(12px);border-bottom:1px solid #e7e5dd;">
        <div style="max-width:1100px;margin:0 auto;padding:13px clamp(16px,4vw,24px);display:flex;align-items:center;gap:18px;flex-wrap:wrap;">
            <x-logo :href="route('dashboard.index')" />
            <nav style="display:flex;align-items:center;gap:6px;margin-left:8px;flex-wrap:wrap;">
                @foreach ($nav as $key => $item)
                    @php $on = $active === $key; @endphp
                    <a href="{{ $item['href'] }}" style="padding:9px 15px;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;text-decoration:none;{{ $on ? 'background:#1f4733;color:#fff;' : 'color:#3a463f;' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>
            <div style="display:flex;align-items:center;gap:10px;margin-left:auto;">
                @if ($trainer)
                    <a href="{{ route('profile', $trainer) }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:7px;padding:10px 16px;border:1.6px solid #cdd6cf;border-radius:999px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#1f4733;text-decoration:none;">Ver meu site <x-icon name="arrow-ur" size="14" sw="2.4" /></a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" style="padding:10px 16px;background:transparent;border:none;cursor:pointer;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#6b7670;">Sair</button>
                </form>
            </div>
        </div>
    </header>

    <main style="max-width:1100px;margin:0 auto;padding:clamp(24px,5vw,44px) clamp(16px,4vw,24px);">
        @if (session('flash'))
            <div x-data="{ show: true }" x-show="show" style="display:flex;align-items:center;gap:12px;background:#e8f0ea;border:1px solid #cfe0d5;color:#1f4733;border-radius:14px;padding:14px 18px;margin-bottom:24px;font:500 14px/1.4 'Inter',sans-serif;">
                <span style="color:#2f7d54;"><x-icon name="check" size="18" sw="2.6" /></span>
                <span style="flex:1;">{{ session('flash') }}</span>
                <button @click="show=false" style="background:none;border:none;cursor:pointer;color:#6b7670;font-size:18px;line-height:1;">&times;</button>
            </div>
        @endif

        {{ $slot }}
    </main>
</div>
</x-layout>
