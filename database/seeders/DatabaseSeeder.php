<?php

namespace Database\Seeders;

use App\Models\Trainer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seed para desenvolvimento local. Em produção roda só o ExampleProfilesSeeder.
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ExampleProfilesSeeder::class);

        // Conta demo para acessar o painel da Marina: demo@corpora.test / senha: password
        $user = User::updateOrCreate(['email' => 'demo@corpora.test'], [
            'name'     => 'Marina Lacerda',
            'password' => Hash::make('password'),
        ]);

        Trainer::where('slug', 'marina-lacerda')->update(['user_id' => $user->id]);
    }
}
