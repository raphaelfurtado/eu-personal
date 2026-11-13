<?php

namespace App\Http\Controllers;

use App\Models\Trainer;
use App\Services\MercadoPago;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /** Página de pagamento do Pro (formulário de cartão do Mercado Pago, sem conta MP). */
    public function checkout(Request $request, MercadoPago $mp)
    {
        $trainer = $request->user()->trainer;

        if ($trainer->isPro()) {
            return redirect()->route('dashboard.index')->with('flash', 'Você já está no Pro 🎉');
        }

        if (! $mp->configured()) {
            return redirect()->route('dashboard.index')
                ->with('flash', 'Pagamento ainda não configurado (defina MP_ACCESS_TOKEN e MP_PUBLIC_KEY no .env).');
        }

        return view('billing.checkout', [
            'publicKey' => config('services.mercadopago.public_key'),
            'price'     => $mp->proPrice(),
            'email'     => $mp->payerEmail($trainer),
        ]);
    }

    /** Recebe o token do cartão (gerado no navegador) e cria a assinatura. Responde JSON pro Brick. */
    public function subscribe(Request $request, MercadoPago $mp)
    {
        $data = $request->validate([
            'token' => ['required', 'string', 'max:255'],
        ]);

        $trainer = $request->user()->trainer;

        if ($trainer->isPro()) {
            return response()->json(['redirect' => route('dashboard.index')]);
        }

        $result = $mp->createSubscription($trainer, $data['token']);

        if (! $result['ok']) {
            return response()->json([
                'message' => 'O pagamento não foi aprovado. Confira os dados do cartão ou tente outro cartão.',
            ], 422);
        }

        $trainer->forceFill(['mp_preapproval_id' => $result['id']])->save();

        if ($result['status'] === 'authorized') {
            $this->activatePro($trainer, $result['id']);
        }

        return response()->json(['redirect' => route('billing.return')]);
    }

    /** Tela de retorno: confirma o status na API (cobre o caso de a assinatura ainda estar pendente). */
    public function callback(Request $request, MercadoPago $mp)
    {
        $trainer = $request->user()->trainer;
        $confirmed = $trainer->isPro();

        if (! $confirmed && ($id = $trainer->mp_preapproval_id)
            && ($pre = $mp->getPreapproval($id)) && ($pre['status'] ?? null) === 'authorized') {
            $this->activatePro($trainer, $id);
            $confirmed = true;
        }

        return view('billing.return', ['confirmed' => $confirmed]);
    }

    /** Cancela a assinatura pelo painel (o assinante não tem conta MP onde cancelar). */
    public function cancel(Request $request, MercadoPago $mp)
    {
        $trainer = $request->user()->trainer;

        if (! $trainer->mp_preapproval_id) {
            return back()->with('flash', 'Não encontramos uma assinatura ativa para cancelar.');
        }

        if (! $mp->cancelSubscription($trainer->mp_preapproval_id)) {
            return back()->with('flash', 'Não consegui cancelar agora. Tente novamente em instantes.');
        }

        $trainer->update(['plan' => 'free']);

        return redirect()->route('dashboard.index')
            ->with('flash', 'Assinatura cancelada. Você não será mais cobrado e voltou para o plano Grátis.');
    }

    /** Webhook do Mercado Pago: fonte da verdade pra renovação/cancelamento. */
    public function webhook(Request $request, MercadoPago $mp)
    {
        $type = $request->input('type') ?? $request->query('topic');
        $id = $request->input('data.id') ?? $request->query('id') ?? $request->input('id');

        if (! $id || ! in_array($type, ['subscription_preapproval', 'preapproval'], true)) {
            return response('OK', 200);
        }

        $id = (string) $id;
        $pre = $mp->getPreapproval($id);

        if (! $pre) {
            return response('OK', 200);
        }

        // acha o personal: id da assinatura → external_reference → e-mail do pagador
        $trainer = Trainer::where('mp_preapproval_id', $id)->first()
            ?? (($tid = MercadoPago::trainerIdFromReference($pre['external_reference'] ?? null)) ? Trainer::find($tid) : null)
            ?? Trainer::whereHas('user', fn ($q) => $q->where('email', $pre['payer_email'] ?? '___nao___'))->first();

        if (! $trainer) {
            return response('OK', 200);
        }

        // aviso de uma assinatura antiga (o personal já tem outra) não mexe no plano atual
        $isCurrent = ! $trainer->mp_preapproval_id || $trainer->mp_preapproval_id === $id;

        match ($pre['status'] ?? null) {
            'authorized' => $this->activatePro($trainer, $id),
            'cancelled', 'paused' => $isCurrent ? $trainer->update(['plan' => 'free']) : null,
            default => null,
        };

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
