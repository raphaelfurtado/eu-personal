<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DevPlanSwitchTest extends TestCase
{
    use RefreshDatabase;

    private function userWithTrainer(): User
    {
        $user = User::factory()->create();
        $user->trainer()->create(['slug' => 'teste', 'name' => 'Teste']);

        return $user;
    }

    public function test_outside_local_the_dev_switch_does_not_exist(): void
    {
        $user = $this->userWithTrainer();

        $this->actingAs($user)->post('/painel/plano', ['plan' => 'pro'])->assertNotFound();
        $this->assertSame('free', $user->trainer->fresh()->plan);

        $this->actingAs($user)->get('/painel')->assertOk()->assertDontSee('Modo teste (dev)');
    }

    public function test_in_local_the_dev_switch_changes_the_plan(): void
    {
        $this->app['env'] = 'local';
        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
        $user = $this->userWithTrainer();

        $this->actingAs($user)->get('/painel')->assertOk()->assertSee('Modo teste (dev)');
        $this->actingAs($user)->post('/painel/plano', ['plan' => 'pro'])->assertRedirect();
        $this->assertSame('pro', $user->trainer->fresh()->plan);
    }
}
