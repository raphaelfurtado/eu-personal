<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeployTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_is_hidden_when_no_token_is_configured(): void
    {
        config(['app.deploy_token' => null]);

        $this->post('/_deploy/migrate', [], ['X-Deploy-Token' => ''])->assertNotFound();
    }

    public function test_it_rejects_a_wrong_token(): void
    {
        config(['app.deploy_token' => 'segredo-certo']);

        $this->post('/_deploy/migrate', [], ['X-Deploy-Token' => 'errado'])->assertNotFound();
    }

    public function test_it_runs_migrations_with_the_right_token(): void
    {
        config(['app.deploy_token' => 'segredo-certo']);

        $this->post('/_deploy/migrate', [], ['X-Deploy-Token' => 'segredo-certo'])
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    }
}
