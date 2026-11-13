<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_landing_page_loads(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_the_landing_page_loads_with_the_demo_profiles(): void
    {
        $this->seed();

        $this->get('/')->assertStatus(200)->assertSee('marina-lacerda');
    }
}
