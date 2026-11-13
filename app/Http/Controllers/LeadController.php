<?php

namespace App\Http\Controllers;

use App\Mail\NewLeadMail;
use App\Models\Trainer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store(Request $request, Trainer $trainer)
    {
        $data = $request->validate([
            'nome'       => ['required', 'string', 'max:120'],
            'whatsapp'   => ['required', 'string', 'max:40'],
            'objetivo'   => ['nullable', 'string', 'max:60'],
            'nivel'      => ['nullable', 'string', 'max:30'],
            'frequencia' => ['nullable', 'string', 'max:30'],
            'local'      => ['nullable', 'string', 'max:30'],
            'restricoes' => ['nullable', 'string', 'max:600'],
            'msg'        => ['nullable', 'string', 'max:2000'],
        ], [], [
            'nome'     => 'nome',
            'whatsapp' => 'WhatsApp',
        ]);

        $lead = $trainer->leads()->create($data);

        // Notifica o personal por e-mail (no ambiente local cai no log).
        if ($email = $trainer->user?->email) {
            try {
                Mail::to($email)->send(new NewLeadMail($lead));
            } catch (\Throwable $e) {
                Log::warning('Falha ao notificar lead por e-mail: '.$e->getMessage());
            }
        }

        // Por enquanto: o agendamento vai direto pro WhatsApp do personal,
        // com os dados do formulário já preenchidos na mensagem.
        if ($trainer->whatsapp) {
            return redirect()->away(
                $trainer->whatsapp_url.'?text='.rawurlencode($this->whatsappMessage($trainer, $lead))
            );
        }

        // Sem WhatsApp cadastrado: cai na confirmação na própria página.
        return redirect()
            ->to(route('profile', $trainer).'#contato')
            ->with('lead_sent', true);
    }

    /** Monta a mensagem do agendamento para o WhatsApp do personal. */
    private function whatsappMessage(Trainer $trainer, $lead): string
    {
        $objetivos = [
            'emagrecimento'   => 'Emagrecimento',
            'hipertrofia'     => 'Hipertrofia / ganho de massa',
            'condicionamento' => 'Condicionamento físico',
            'reabilitacao'    => 'Reabilitação / postura',
            'outro'           => 'Outro',
        ];

        $linhas = array_filter([
            "Olá, {$trainer->name}! Quero agendar minha avaliação pela PersonalBio.",
            '',
            "Nome: {$lead->nome}",
            "WhatsApp: {$lead->whatsapp}",
            $lead->objetivo   ? 'Objetivo: '.($objetivos[$lead->objetivo] ?? $lead->objetivo) : null,
            $lead->nivel      ? "Nível: {$lead->nivel}" : null,
            $lead->frequencia ? "Frequência: {$lead->frequencia}" : null,
            $lead->local      ? "Onde treina: {$lead->local}" : null,
            $lead->restricoes ? "Lesões/restrições: {$lead->restricoes}" : null,
            $lead->msg        ? "Mensagem: {$lead->msg}" : null,
        ], fn ($l) => $l !== null);

        return implode("\n", $linhas);
    }
}
