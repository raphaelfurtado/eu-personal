<?php

namespace App\Services;

use App\Models\Trainer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Assinaturas do Mercado Pago "com pagamento autorizado" (sem plano associado).
 *
 * O cartão é tokenizado no navegador pelo Card Payment Brick (os dados do cartão
 * nunca passam pelo nosso servidor) e aqui criamos o preapproval já "authorized".
 * O assinante NÃO precisa ter conta no Mercado Pago. O MP cobra todo mês sozinho
 * e avisa mudanças de status pelo webhook (tópico subscription_preapproval).
 */
class MercadoPago
{
    private string $base = 'https://api.mercadopago.com';

    public function configured(): bool
    {
        return ! empty(config('services.mercadopago.token'))
            && ! empty(config('services.mercadopago.public_key'));
    }

    public function proPrice(): float
    {
        return (float) config('services.mercadopago.pro_price', 39);
    }

    /**
     * E-mail do pagador enviado ao MP. Em teste o MP exige que o pagador seja um
     * usuário de teste, então MP_TEST_PAYER_EMAIL substitui o e-mail da conta
     * (nunca em produção).
     */
    public function payerEmail(Trainer $trainer): string
    {
        $test = config('services.mercadopago.test_payer');

        if ($test && ! app()->isProduction()) {
            return $test;
        }

        return $trainer->user->email;
    }

    public static function externalReference(Trainer $trainer): string
    {
        return 'trainer-'.$trainer->id;
    }

    /** Id do personal a partir do external_reference ("trainer-12" → 12). */
    public static function trainerIdFromReference(?string $ref): ?int
    {
        return $ref && preg_match('/^trainer-(\d+)$/', $ref, $m) ? (int) $m[1] : null;
    }

    /**
     * Cria a assinatura mensal do Pro com o cartão tokenizado.
     *
     * @return array{ok: bool, id?: string, status?: string, error?: string}
     */
    public function createSubscription(Trainer $trainer, string $cardToken): array
    {
        $resp = Http::withToken(config('services.mercadopago.token'))
            ->acceptJson()
            ->post($this->base.'/preapproval', [
                'reason'             => 'PersonalBio Pro',
                'external_reference' => self::externalReference($trainer),
                'payer_email'        => $this->payerEmail($trainer),
                'card_token_id'      => $cardToken,
                'back_url'           => route('billing.return'),
                'status'             => 'authorized',
                'auto_recurring'     => [
                    'frequency'          => 1,
                    'frequency_type'     => 'months',
                    'transaction_amount' => $this->proPrice(),
                    'currency_id'        => 'BRL',
                ],
            ]);

        if (! $resp->successful() || empty($resp->json('id'))) {
            Log::warning('MercadoPago: falha ao criar assinatura', [
                'trainer' => $trainer->id,
                'status'  => $resp->status(),
                'body'    => $resp->json(),
            ]);

            return ['ok' => false, 'error' => (string) ($resp->json('message') ?? 'erro desconhecido')];
        }

        return ['ok' => true, 'id' => (string) $resp->json('id'), 'status' => (string) $resp->json('status')];
    }

    /** Cancela a assinatura no MP (para de cobrar). */
    public function cancelSubscription(string $id): bool
    {
        $resp = Http::withToken(config('services.mercadopago.token'))
            ->acceptJson()
            ->put($this->base.'/preapproval/'.$id, ['status' => 'cancelled']);

        if (! $resp->successful()) {
            Log::warning('MercadoPago: falha ao cancelar assinatura', [
                'id'     => $id,
                'status' => $resp->status(),
                'body'   => $resp->json(),
            ]);
        }

        return $resp->successful();
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
