<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Court;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        // On crée 3 terrains avec des prix différents
        Court::create(['name' => 'Terrain Alpha', 'price_coins' => 100, 'is_active' => true]);
        Court::create(['name' => 'Terrain Beta', 'price_coins' => 150, 'is_active' => true]);
        Court::create(['name' => 'Terrain VIP', 'price_coins' => 300, 'is_active' => true]);
    }
}
