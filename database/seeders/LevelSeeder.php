<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        // On crée nos 3 niveaux de base
        Level::create(['level_name' => 'Débutant', 'min_xp' => 0]);
        Level::create(['level_name' => 'Intermédiaire', 'min_xp' => 1000]);
        Level::create(['level_name' => 'Pro', 'min_xp' => 5000]);
    }
}
