<?php

namespace Tests\Feature;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request as HttpRequest;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BillingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.mercadopago.token'      => 'TEST-token',
            'services.mercadopago.public_key' => 'TEST-public',
            'services.mercadopago.pro_price'  => 39,
            'services.mercadopago.test_payer' => null,
        ]);
    }

    private function trainer(array $attrs = []): Trainer
    {
        $user = User::factory()->create(['email' => 'personal@example.com']);

        return $user->trainer()->create(['slug' => 'teste', 'name' => 'Teste'] + $attrs);
    }

    public function test_checkout_page_shows_the_card_form(): void
    {
        $trainer = $this->trainer();

        $this->actingAs($trainer->user)->get('/painel/assinar')
            ->assertOk()
            ->assertSee('cardPaymentBrick_container')
            ->assertSee('TEST-public');
    }

    public function test_pro_trainer_is_sent_back_to_the_dashboard(): void
    {
        $trainer = $this->trainer(['plan' => 'pro']);

        $this->actingAs($trainer->user)->get('/painel/assinar')->assertRedirect('/painel');
    }

    public function test_authorized_subscription_turns_the_trainer_pro(): void
    {
        Http::fake([
            'api.mercadopago.com/preapproval' => Http::response(['id' => 'pre-1', 'status' => 'authorized'], 201),
        ]);
        $trainer = $this->trainer();

        $this->actingAs($trainer->user)
            ->postJson('/painel/assinar', ['token' => 'card-token'])
            ->assertOk()
            ->assertJson(['redirect' => route('billing.return')]);

        $trainer->refresh();
        $this->assertSame('pro', $trainer->plan);
        $this->assertSame('pre-1', $trainer->mp_preapproval_id);

        Http::assertSent(fn (HttpRequest $r) => $r->method() === 'POST'
            && $r['card_token_id'] === 'card-token'
            && $r['status'] === 'authorized'
            && $r['payer_email'] === 'personal@example.com'
            && $r['external_reference'] === 'trainer-'.$trainer->id
            && $r['auto_recurring']['transaction_amount'] == 39);
    }

    public function test_test_payer_email_replaces_the_account_email_outside_production(): void
    {
        config(['services.mercadopago.test_payer' => 'test_user_1@testuser.com']);
        Http::fake(['api.mercadopago.com/preapproval' => Http::response(['id' => 'pre-1', 'status' => 'authorized'], 201)]);
        $trainer = $this->trainer();

        $this->actingAs($trainer->user)->postJson('/painel/assinar', ['token' => 'card-token'])->assertOk();

        Http::assertSent(fn (HttpRequest $r) => $r['payer_email'] === 'test_user_1@testuser.com');
    }

    public function test_rejected_card_keeps_the_trainer_free(): void
    {
        Http::fake([
            'api.mercadopago.com/preapproval' => Http::response(['message' => 'CC_VAL_433 Credit card validation has failed'], 400),
        ]);
        $trainer = $this->trainer();

        $this->actingAs($trainer->user)
            ->postJson('/painel/assinar', ['token' => 'card-token'])
            ->assertStatus(422)
            ->assertJsonStructure(['message']);

        $this->assertSame('free', $trainer->fresh()->plan);
    }

    public function test_cancel_stops_the_subscription_and_goes_back_to_free(): void
    {
        Http::fake(['api.mercadopago.com/preapproval/pre-1' => Http::response(['id' => 'pre-1', 'status' => 'cancelled'])]);
        $trainer = $this->trainer(['plan' => 'pro', 'mp_preapproval_id' => 'pre-1']);

        $this->actingAs($trainer->user)->get('/painel')->assertOk()->assertSee('Cancelar assinatura');
        $this->actingAs($trainer->user)->post('/painel/assinatura/cancelar')->assertRedirect('/painel');

        $this->assertSame('free', $trainer->fresh()->plan);
        Http::assertSent(fn (HttpRequest $r) => $r->method() === 'PUT' && $r['status'] === 'cancelled');
    }

    public function test_failed_cancel_keeps_the_trainer_pro(): void
    {
        Http::fake(['api.mercadopago.com/preapproval/pre-1' => Http::response(['message' => 'erro'], 500)]);
        $trainer = $this->trainer(['plan' => 'pro', 'mp_preapproval_id' => 'pre-1']);

        $this->actingAs($trainer->user)->post('/painel/assinatura/cancelar')->assertRedirect();

        $this->assertSame('pro', $trainer->fresh()->plan);
    }

    public function test_webhook_cancelled_turns_the_trainer_free(): void
    {
        Http::fake(['api.mercadopago.com/preapproval/pre-1' => Http::response(['id' => 'pre-1', 'status' => 'cancelled'])]);
        $trainer = $this->trainer(['plan' => 'pro', 'mp_preapproval_id' => 'pre-1']);

        $this->postJson('/webhooks/mercadopago', ['type' => 'subscription_preapproval', 'data' => ['id' => 'pre-1']])->assertOk();

        $this->assertSame('free', $trainer->fresh()->plan);
    }

    public function test_webhook_finds_the_trainer_by_external_reference(): void
    {
        $trainer = $this->trainer();
        Http::fake(['api.mercadopago.com/preapproval/pre-9' => Http::response([
            'id' => 'pre-9', 'status' => 'authorized', 'external_reference' => 'trainer-'.$trainer->id, 'payer_email' => 'outro@example.com',
        ])]);

        $this->postJson('/webhooks/mercadopago', ['type' => 'subscription_preapproval', 'data' => ['id' => 'pre-9']])->assertOk();

        $trainer->refresh();
        $this->assertSame('pro', $trainer->plan);
        $this->assertSame('pre-9', $trainer->mp_preapproval_id);
    }

    public function test_webhook_about_an_old_subscription_does_not_downgrade(): void
    {
        $trainer = $this->trainer(['plan' => 'pro', 'mp_preapproval_id' => 'pre-new']);
        Http::fake(['api.mercadopago.com/preapproval/pre-old' => Http::response([
            'id' => 'pre-old', 'status' => 'cancelled', 'external_reference' => 'trainer-'.$trainer->id,
        ])]);

        $this->postJson('/webhooks/mercadopago', ['type' => 'subscription_preapproval', 'data' => ['id' => 'pre-old']])->assertOk();

        $this->assertSame('pro', $trainer->fresh()->plan);
    }
}
