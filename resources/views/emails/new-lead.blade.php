@php $objetivos = [
    'emagrecimento'  => 'Emagrecimento',
    'hipertrofia'    => 'Hipertrofia / ganho de massa',
    'condicionamento'=> 'Condicionamento físico',
    'reabilitacao'   => 'Reabilitação / postura',
    'outro'          => 'Outro',
]; @endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;background:#f5f4ef;font-family:Arial,Helvetica,sans-serif;color:#1b2520;">
    <div style="max-width:560px;margin:0 auto;padding:24px;">
        <div style="background:#1f4733;color:#fff;border-radius:16px 16px 0 0;padding:24px 28px;">
            <div style="font-size:13px;letter-spacing:1px;text-transform:uppercase;color:#d8a32e;margin-bottom:6px;">PersonalBio · Novo lead</div>
            <div style="font-size:22px;font-weight:bold;">Você recebeu um novo contato 🎉</div>
        </div>
        <div style="background:#fff;border:1px solid #ece9e0;border-top:none;border-radius:0 0 16px 16px;padding:24px 28px;">
            <p style="margin:0 0 18px;color:#4a564f;font-size:15px;line-height:1.5;">Alguém preencheu o formulário do seu perfil <strong>{{ $lead->trainer->name }}</strong>:</p>

            <table style="width:100%;border-collapse:collapse;font-size:15px;">
                <tr><td style="padding:8px 0;color:#6b7670;width:120px;">Nome</td><td style="padding:8px 0;font-weight:bold;">{{ $lead->nome }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7670;">WhatsApp</td><td style="padding:8px 0;font-weight:bold;">{{ $lead->whatsapp }}</td></tr>
                <tr><td style="padding:8px 0;color:#6b7670;">Objetivo</td><td style="padding:8px 0;">{{ $objetivos[$lead->objetivo] ?? ($lead->objetivo ?: '—') }}</td></tr>
                @if ($lead->msg)
                    <tr><td style="padding:8px 0;color:#6b7670;vertical-align:top;">Mensagem</td><td style="padding:8px 0;">{{ $lead->msg }}</td></tr>
                @endif
            </table>

            @if ($lead->whatsapp_url)
                <a href="{{ $lead->whatsapp_url }}" style="display:inline-block;margin-top:20px;padding:14px 24px;background:#1f4733;color:#fff;border-radius:999px;text-decoration:none;font-weight:bold;font-size:14px;">Responder no WhatsApp →</a>
            @endif

            <p style="margin:22px 0 0;color:#8a9690;font-size:12px;">Recebido em {{ $lead->created_at->format('d/m/Y H:i') }} · veja todos os contatos no seu painel.</p>
        </div>
    </div>
</body>
</html>
