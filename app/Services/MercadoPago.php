<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Assinaturas do Mercado Pago via PLANO (preapproval_plan).
 * O personal é levado ao init_point do plano (checkout hospedado: cartão de crédito);
 * o MP avisa por webhook e o retorno (back_url) confirma e libera o Pro.
 */
class MercadoPago
{
    private string $base = 'https://api.mercadopago.com';

    public function configured(): bool
    {
        return ! empty(config('services.mercadopago.token'));
    }

    /** Link de checkout do plano Pro (cria o plano uma vez e reaproveita). */
    public function proPlanInitPoint(): ?string
    {
        $price = (float) config('services.mercadopago.pro_price', 39);
        $key = 'mp_pro_plan_initpoint_cconly_'.(int) $price;  // só cartão (sem boleto)

        if ($cached = Cache::get($key)) {
            return $cached;
        }

        $resp = Http::withToken(config('services.mercadopago.token'))
            ->acceptJson()
            ->post($this->base.'/preapproval_plan', [
                'reason'         => 'PersonalBio Pro',
                'back_url'       => route('billing.return'),
                'auto_recurring' => [
                    'frequency'          => 1,
                    'frequency_type'     => 'months',
                    'transaction_amount' => $price,
                    'currency_id'        => 'BRL',
                ],
                // nível raiz: só cartão de crédito (remove boleto do checkout da assinatura)
                'payment_methods_allowed' => [
                    'payment_types'   => [['id' => 'credit_card']],
                    'payment_methods' => [],
                ],
            ]);

        if (! $resp->successful() || empty($resp->json()['init_point'])) {
            Log::warning('MercadoPago: falha ao criar plano', ['status' => $resp->status(), 'body' => $resp->json()]);

            return null;
        }

        $initPoint = $resp->json()['init_point'];
        Cache::forever($key, $initPoint);

        return $initPoint;
    }

    /** Consulta o status de uma assinatura (preapproval). */
    public function getPreapproval(string $id): ?array
    {
        $resp = Http::withToken(config('services.mercadopago.token'))
            ->acceptJson()
            ->get($this->base.'/preapproval/'.$id);

        return $resp->successful() ? $resp->json() : null;
    }
}
