<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Services\MercadoPago;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /** Inicia a assinatura Pro: cria o preapproval e manda o personal pro checkout do MP. */
    public function subscribe(Request $request, MercadoPago $mp)
    {
        $trainer = $request->user()->trainer;

        if ($trainer->isPro()) {
            return redirect()->route('dashboard.index')->with('flash', 'Você já está no Pro 🎉');
        }

        if (! $mp->configured()) {
            return back()->with('flash', 'Pagamento ainda não configurado (defina MP_ACCESS_TOKEN no .env).');
        }

        $initPoint = $mp->proPlanInitPoint();

        if (! $initPoint) {
            return back()->with('flash', 'Não consegui abrir o checkout agora. Tente novamente em instantes.');
        }

        return redirect()->away($initPoint);
    }

    /** Retorno do checkout (back_url): confirma o status na API e libera o Pro. */
    public function callback(Request $request, MercadoPago $mp)
    {
        $trainer = $request->user()->trainer;
        $id = $request->query('preapproval_id') ?: $trainer->mp_preapproval_id;
        $confirmed = false;

        if ($id && ($pre = $mp->getPreapproval($id)) && ($pre['status'] ?? null) === 'authorized') {
            $this->activatePro($trainer, $id);
            $confirmed = true;
        }

        return view('billing.return', ['confirmed' => $confirmed]);
    }

    /** Webhook do Mercado Pago: fonte da verdade pra renovação/cancelamento. */
    public function webhook(Request $request, MercadoPago $mp)
    {
        $type = $request->input('type') ?? $request->query('topic');
        $id = $request->input('data.id') ?? $request->query('id') ?? $request->input('id');

        if ($id && in_array($type, ['subscription_preapproval', 'preapproval'], true)) {
            if ($pre = $mp->getPreapproval((string) $id)) {
                // mapeia pelo id salvo; senão, pelo e-mail do pagador (= e-mail da conta)
                $trainer = Trainer::where('mp_preapproval_id', $id)->first()
                    ?? Trainer::whereHas('user', fn ($q) => $q->where('email', $pre['payer_email'] ?? '___nao___'))->first();

                if ($trainer) {
                    match ($pre['status'] ?? null) {
                        'authorized' => $this->activatePro($trainer, (string) $id),
                        'cancelled', 'paused' => tap($trainer)->update(['plan' => 'free']),
                        default => null,
                    };
                }
            }
        }

        return response('OK', 200);
    }

    private function activatePro(Trainer $trainer, string $preapprovalId): void
    {
        $trainer->forceFill([
            'plan'              => 'pro',
            'plan_until'        => now()->addMonth(),
            'mp_preapproval_id' => $preapprovalId,
        ])->save();
    }
}
