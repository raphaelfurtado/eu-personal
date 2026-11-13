<x-dashboard-layout title="Visão geral" active="index">
    <div style="margin-bottom:30px;">
        <h1 style="font:700 clamp(28px,4vw,38px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 8px;">Olá, {{ explode(' ', $trainer->name)[0] }} 👋</h1>
        <p style="font:400 16px/1.5 'Inter',sans-serif;color:#6b7670;margin:0;">Seu perfil está no ar em
            <a href="{{ route('profile', $trainer) }}" target="_blank" rel="noopener" style="color:#1f4733;font-weight:600;">{{ config('app.domain') }}/{{ $trainer->slug }}</a>.
        </p>
        <p style="font:400 15px/1.5 'Inter',sans-serif;color:#6b7670;margin:8px 0 0;">Versão enxuta pra bio do Instagram:
            <a href="{{ route('profile.bio', $trainer) }}" target="_blank" rel="noopener" style="color:#1f4733;font-weight:600;">{{ config('app.domain') }}/{{ $trainer->slug }}/bio</a>.
        </p>
    </div>

    {{-- cards de números --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:30px;">
        @foreach ([
            ['n' => $trainer->leads_count, 'label' => 'Leads recebidos', 'href' => route('dashboard.leads')],
            ['n' => $trainer->certifications_count, 'label' => 'Qualificações', 'href' => route('dashboard.profile.edit').'#qualificacoes'],
            ['n' => $trainer->results_count, 'label' => 'Resultados', 'href' => route('dashboard.profile.edit').'#resultados'],
        ] as $c)
            <a href="{{ $c['href'] }}" style="background:#fff;border:1px solid #ece9e0;border-radius:18px;padding:24px;text-decoration:none;display:block;">
                <div style="font:700 40px/1 'Oswald',sans-serif;color:#1f4733;">{{ $c['n'] }}</div>
                <div style="font:500 14px/1.3 'Inter',sans-serif;color:#6b7670;margin-top:6px;">{{ $c['label'] }}</div>
            </a>
        @endforeach
    </div>

    {{-- plano + assinatura --}}
    <div style="background:#fff;border:1px solid #ece9e0;border-radius:18px;padding:24px;margin-bottom:30px;">
        <div style="display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
            <div>
                <div style="font:600 12px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#8a9690;margin-bottom:6px;">Seu plano</div>
                <div style="font:700 24px/1 'Oswald',sans-serif;color:#1f4733;display:flex;align-items:center;gap:8px;">{{ $trainer->plan_label }} @if($trainer->isPro())<span style="font:600 11px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;color:#2f7d54;background:#e8f0ea;padding:5px 9px;border-radius:7px;">ativo</span>@endif</div>
            </div>
            @unless ($trainer->isPro())
                <a href="{{ route('billing.checkout') }}" style="display:inline-flex;align-items:center;gap:9px;padding:14px 26px;background:#1f4733;color:#fff;border-radius:999px;font:600 14px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;box-shadow:0 8px 22px rgba(31,71,51,.18);">Assinar Pro · R$39/mês <x-icon name="arrow-right" size="16" sw="2.4" /></a>
            @endunless
            @if ($trainer->isPro() && $trainer->mp_preapproval_id)
                <form method="POST" action="{{ route('billing.cancel') }}" onsubmit="return confirm('Cancelar a assinatura Pro? Você não será mais cobrado e volta para o plano Grátis agora.');">
                    @csrf
                    <button type="submit" style="padding:11px 18px;background:transparent;border:1.5px solid #e0ddd3;border-radius:999px;cursor:pointer;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#8a5a4a;">Cancelar assinatura</button>
                </form>
            @endif
        </div>
        @unless ($trainer->isPro())
            <div style="font:400 12px/1.3 'Inter',sans-serif;color:#8a9690;margin-top:10px;">💳 Pagamento seguro com cartão de crédito, processado pelo <strong>Mercado Pago</strong> — não precisa ter conta no Mercado Pago. Cancele quando quiser.</div>
        @endunless

        {{-- modo teste (dev): simula o plano sem cobrar — só em ambiente local --}}
        @if (app()->isLocal())
        <div style="border-top:1px dashed #e0ddd3;margin-top:18px;padding-top:16px;">
            <div style="font:600 11px/1 'Oswald',sans-serif;letter-spacing:1px;text-transform:uppercase;color:#b08900;margin-bottom:9px;">🧪 Modo teste (dev) — sem cobrança</div>
            <form method="POST" action="{{ route('dashboard.plan.set') }}" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;">
                @csrf
                @foreach (['free', 'pro'] as $p)
                    @php $cur = $trainer->planKey() === $p; @endphp
                    <button name="plan" value="{{ $p }}" type="submit" style="padding:9px 14px;border-radius:9px;border:1.5px solid {{ $cur ? '#1f4733' : '#e0ddd3' }};background:{{ $cur ? '#1f4733' : '#fff' }};color:{{ $cur ? '#fff' : '#6b7670' }};font:600 11px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;cursor:pointer;">Simular {{ config('plans.labels.'.$p) }}</button>
                @endforeach
                <span style="font:400 12px/1.3 'Inter',sans-serif;color:#8a9690;">Só muda o plano localmente pra testar limites/recursos. <strong>Studio</strong> é sob consulta (Falar com vendas).</span>
            </form>
        </div>
        @endif
    </div>

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
        {{-- atalho editar --}}
        <div style="background:#1f4733;border-radius:20px;padding:28px;color:#fff;">
            <h2 style="font:600 21px/1.2 'Oswald',sans-serif;margin:0 0 8px;">Personalize seu perfil</h2>
            <p style="font:400 15px/1.55 'Inter',sans-serif;color:#bcd4c5;margin:0 0 20px;">Edite textos, fotos, cor de destaque e seu logo — tudo reflete no seu site na hora.</p>
            <a href="{{ route('dashboard.profile.edit') }}" style="display:inline-flex;align-items:center;gap:8px;padding:13px 22px;background:var(--accent,#d8a32e);color:#1b2520;border-radius:999px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.8px;text-transform:uppercase;text-decoration:none;">Editar perfil <x-icon name="arrow-right" size="15" sw="2.4" /></a>
        </div>

        {{-- leads recentes --}}
        <div style="background:#fff;border:1px solid #ece9e0;border-radius:20px;padding:28px;">
            <h2 style="font:600 21px/1.2 'Oswald',sans-serif;color:#1b2520;margin:0 0 16px;">Contatos recentes</h2>
            @forelse ($recentLeads as $lead)
                <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;padding:11px 0;border-bottom:1px solid #f0eee6;">
                    <div><div style="font:600 15px/1.2 'Oswald',sans-serif;color:#1b2520;">{{ $lead->nome }}</div><div style="font:400 13px/1.3 'Inter',sans-serif;color:#6b7670;">{{ $lead->whatsapp }}</div></div>
                    <div style="font:400 12px/1.2 'Inter',sans-serif;color:#8a9690;white-space:nowrap;">{{ $lead->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <p style="font:400 14px/1.5 'Inter',sans-serif;color:#6b7670;margin:0;">Nenhum contato ainda. Compartilhe seu link na bio do Instagram para começar a captar.</p>
            @endforelse
            @if ($recentLeads->isNotEmpty())
                <a href="{{ route('dashboard.leads') }}" style="display:inline-block;margin-top:14px;font:600 13px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;color:#1f4733;text-decoration:none;">Ver todos →</a>
            @endif
        </div>
    </div>
</x-dashboard-layout>
