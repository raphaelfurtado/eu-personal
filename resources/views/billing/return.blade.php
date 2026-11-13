<x-dashboard-layout title="Assinatura" active="index">
    <div style="max-width:560px;margin:clamp(20px,5vw,48px) auto;text-align:center;background:#fff;border:1px solid #ece9e0;border-radius:22px;padding:clamp(32px,5vw,52px) clamp(24px,4vw,40px);">
        @if ($confirmed)
            <span style="width:74px;height:74px;border-radius:50%;background:#e8f0ea;display:inline-flex;align-items:center;justify-content:center;margin-bottom:22px;color:#2f7d54;">
                <x-icon name="check" size="38" sw="2.4" />
            </span>
            <h1 style="font:700 clamp(26px,4vw,34px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 12px;">Assinatura confirmada! 🎉</h1>
            <p style="font:400 16px/1.6 'Inter',sans-serif;color:#6b7670;margin:0 auto 28px;max-width:42ch;">Seu plano <strong style="color:#1f4733;">Pro</strong> está ativo. A marca PersonalBio saiu do seu site, o logo próprio foi liberado e agora você tem resultados, links e pacotes ilimitados, além de até {{ config('plans.pro.limits.testimonials') }} depoimentos.</p>
            <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
                <a href="{{ route('dashboard.index') }}" style="padding:14px 26px;background:#1f4733;color:#fff;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Ir para o painel</a>
                <a href="{{ route('profile', auth()->user()->trainer) }}" target="_blank" rel="noopener" style="padding:14px 26px;background:transparent;color:#1f4733;border:1.6px solid #cdd6cf;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Ver meu site</a>
            </div>
        @else
            <span style="width:74px;height:74px;border-radius:50%;background:#f6ecd2;display:inline-flex;align-items:center;justify-content:center;margin-bottom:22px;color:#8a6512;">
                <x-icon name="clock" size="36" />
            </span>
            <h1 style="font:700 clamp(26px,4vw,34px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 12px;">Estamos confirmando seu pagamento…</h1>
            <p style="font:400 16px/1.6 'Inter',sans-serif;color:#6b7670;margin:0 auto 28px;max-width:42ch;">Recebemos sua assinatura. Assim que o Mercado Pago confirmar (costuma ser em instantes), o <strong>Pro</strong> é liberado automaticamente — você não precisa fazer mais nada.</p>
            <a href="{{ route('dashboard.index') }}" style="padding:14px 26px;background:#1f4733;color:#fff;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Voltar ao painel</a>
        @endif
    </div>
</x-dashboard-layout>
