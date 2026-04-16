<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. On lance la création des niveaux et terrains
        $this->call([
            LevelSeeder::class,
            CourtSeeder::class,
        ]);

        // 2. On se crée un compte Admin par défaut pour que tu puisses te connecter plus tard !
        User::create([
            'name' => 'Admin PadelPlaza',
            'email' => 'admin@padelplaza.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
        ]);
    }
}
