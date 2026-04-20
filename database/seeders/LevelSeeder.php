<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        Level::query()->delete(); // On nettoie les anciens niveaux d'abord
        
        $levels = [
            ['level_name' => 'Bois', 'min_xp' => 0],
            ['level_name' => 'Bronze', 'min_xp' => 1000],
            ['level_name' => 'Argent', 'min_xp' => 1500],
            ['level_name' => 'Or', 'min_xp' => 2000],
            ['level_name' => 'Platine', 'min_xp' => 2500],
            ['level_name' => 'Diamant', 'min_xp' => 3000],
            ['level_name' => 'Saphir', 'min_xp' => 3500],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
