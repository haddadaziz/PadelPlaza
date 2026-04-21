<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // On crée les niveaux en premier
        $this->call([LevelSeeder::class , CourtSeeder::class]);

        $boisLevel = \App\Models\Level::where('level_name', 'Bois')->first();

        // Admin : level_id reste NULL par défaut
        \App\Models\User::create([
            'name' => 'Admin PadelPlaza',
            'email' => 'admin@padelplaza.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'admin',
        ]);

        // Joueur : on lui donne son niveau Bois
        \App\Models\User::create([
            'name' => 'Joueur Test',
            'email' => 'player@padelplaza.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'player',
            'coins_balance' => 500,
            'xp_points' => 0,
            'level_id' => $boisLevel->id,
        ]);
    }

}
