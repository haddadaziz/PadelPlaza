<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        Level::query()->delete(); // On nettoie tout

        $levels = [
            ['level_name' => 'Bois',    'min_xp' => 0,     'badge_image' => 'badges/bois.png'],
            ['level_name' => 'Bronze',  'min_xp' => 1000,  'badge_image' => 'badges/bronze.png'],
            ['level_name' => 'Argent',  'min_xp' => 2500,  'badge_image' => 'badges/argent.png'],
            ['level_name' => 'Or',      'min_xp' => 4500,  'badge_image' => 'badges/or.png'],
            ['level_name' => 'Platine', 'min_xp' => 7000,  'badge_image' => 'badges/platine.png'],
            ['level_name' => 'Diamant', 'min_xp' => 10000, 'badge_image' => 'badges/diamant.png'],
            ['level_name' => 'Saphir',  'min_xp' => 13500, 'badge_image' => 'badges/saphir.png'],
        ];

        foreach ($levels as $level) {
            Level::create($level);
        }
    }
}
