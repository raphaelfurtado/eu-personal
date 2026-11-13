<?php

namespace Tests\Feature;

use App\Models\Trainer;
use App\Models\User;
use Database\Seeders\ExampleProfilesSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleProfilesSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_the_example_profiles_without_any_user(): void
    {
        $this->seed(ExampleProfilesSeeder::class);

        $this->assertEqualsCanonicalizing(
            ['marina-lacerda', 'bruno-tavares'],
            Trainer::pluck('slug')->all()
        );
        $this->assertSame(0, User::count());

        $this->get('/marina-lacerda')->assertOk();
        $this->get('/bruno-tavares/bio')->assertOk();
    }

    public function test_running_it_again_does_not_duplicate_anything(): void
    {
        $this->seed(ExampleProfilesSeeder::class);
        $this->seed(ExampleProfilesSeeder::class);

        $marina = Trainer::where('slug', 'marina-lacerda')->first();

        $this->assertSame(2, Trainer::count());
        $this->assertSame(3, $marina->results()->count());
        $this->assertSame(3, $marina->packages()->count());
    }

    public function test_it_keeps_the_owner_set_by_the_local_seeder(): void
    {
        $this->seed();
        $this->seed(ExampleProfilesSeeder::class);

        $this->assertNotNull(Trainer::where('slug', 'marina-lacerda')->value('user_id'));
    }
}
