@php $objetivos = [
    'emagrecimento'  => 'Emagrecimento',
    'hipertrofia'    => 'Hipertrofia',
    'condicionamento'=> 'Condicionamento',
    'reabilitacao'   => 'Reabilitação',
    'outro'          => 'Outro',
]; @endphp
<x-dashboard-layout title="Leads" active="leads">
    <h1 style="font:700 clamp(28px,4vw,38px)/1.05 'Oswald',sans-serif;color:#1b2520;margin:0 0 8px;">Leads recebidos</h1>
    <p style="font:400 16px/1.5 'Inter',sans-serif;color:#6b7670;margin:0 0 28px;">Contatos enviados pelo formulário do seu perfil.</p>

    @forelse ($leads as $lead)
        <div style="background:#fff;border:1px solid #ece9e0;border-radius:16px;padding:20px 22px;margin-bottom:14px;display:flex;flex-wrap:wrap;align-items:center;gap:16px;">
            <div style="flex:1;min-width:180px;">
                <div style="font:600 18px/1.2 'Oswald',sans-serif;color:#1b2520;">{{ $lead->nome }}</div>
                <div style="font:400 14px/1.4 'Inter',sans-serif;color:#6b7670;margin-top:3px;">{{ $lead->whatsapp }}
                    @if ($lead->objetivo) · <span style="color:#2f7d54;">{{ $objetivos[$lead->objetivo] ?? $lead->objetivo }}</span>@endif
                </div>
                @if ($lead->nivel || $lead->frequencia || $lead->local)
                    <div style="display:flex;flex-wrap:wrap;gap:7px;margin-top:9px;">
                        @foreach (array_filter([$lead->nivel, $lead->frequencia, $lead->local]) as $chip)
                            <span style="font:600 11px/1 'Oswald',sans-serif;letter-spacing:.5px;text-transform:uppercase;color:#1f4733;background:#e8f0ea;padding:6px 10px;border-radius:7px;">{{ $chip }}</span>
                        @endforeach
                    </div>
                @endif
                @if ($lead->restricoes)<div style="font:400 13px/1.4 'Inter',sans-serif;color:#c0392b;margin-top:8px;">⚠ Restrições: {{ $lead->restricoes }}</div>@endif
                @if ($lead->msg)<div style="font:400 14px/1.5 'Inter',sans-serif;color:#4a564f;margin-top:8px;font-style:italic;">"{{ $lead->msg }}"</div>@endif
            </div>
            <div style="font:400 12px/1.3 'Inter',sans-serif;color:#8a9690;white-space:nowrap;">{{ $lead->created_at->format('d/m/Y H:i') }}</div>
            @if ($lead->whatsapp_url)
                <a href="{{ $lead->whatsapp_url }}" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;gap:7px;padding:11px 18px;background:#1f4733;color:#fff;border-radius:999px;font:600 12px/1 'Oswald',sans-serif;letter-spacing:.6px;text-transform:uppercase;text-decoration:none;"><x-icon name="whatsapp" size="16" /> Responder</a>
            @endif
        </div>
    @empty
        <div style="background:#fff;border:1px dashed #d8d4c8;border-radius:16px;padding:40px;text-align:center;">
            <p style="font:400 15px/1.5 'Inter',sans-serif;color:#6b7670;margin:0;">Nenhum lead ainda. Quando alguém preencher seu formulário, aparece aqui (e você recebe um e-mail).</p>
        </div>
    @endforelse
</x-dashboard-layout>
