<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. On crée les niveaux en premier (Indispensable !)
        $this->call([LevelSeeder::class]);

        // On charge tous les niveaux disponibles pour pouvoir piocher au hasard
        $allLevels = Level::all();

        // 2. Création du compte ADMIN
        User::create([
            'name' => 'Admin Padel Plaza',
            'email' => 'admin@padelplaza.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 3. Liste des 30 légendes du tennis
        $tennisStars = [
            'Roger Federer', 'Rafael Nadal', 'Novak Djokovic', 'Serena Williams', 
            'Steffi Graf', 'Andre Agassi', 'Pete Sampras', 'Bjorn Borg', 
            'Carlos Alcaraz', 'Jannik Sinner', 'Daniil Medvedev', 'Iga Swiatek',
            'Venus Williams', 'Maria Sharapova', 'Andy Murray', 'Stan Wawrinka',
            'Coco Gauff', 'Aryna Sabalenka', 'Ons Jabeur', 'Gael Monfils',
            'Richard Gasquet', 'Nick Kyrgios', 'Caroline Garcia', 'Holger Rune',
            'Casper Ruud', 'Alexander Zverev', 'Stefanos Tsitsipas', 'Ben Shelton',
            'Frances Tiafoe', 'Arthur Fils'
        ];

        foreach ($tennisStars as $name) {
            $email = Str::slug($name) . '@example.com';
            
            // Piocher un niveau au hasard parmi les 7 niveaux (Bois à Saphir)
            $randomLevel = $allLevels->random();
            // On lui donne une XP cohérente (son palier minimum + un petit bonus aléatoire)
            $randomXp = $randomLevel->min_xp + rand(0, 800);

            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'player',
                'coins_balance' => rand(100, 2000), // Un peu d'argent aléatoire
                'xp_points' => $randomXp,           // XP cohérente avec le niveau
                'level_id' => $randomLevel->id,     // Le niveau au hasard
                // On utilise un avatar aléatoire basé sur le nom
                'profile_image' => 'https://i.pravatar.cc/150?u=' . $email,
            ]);
        }
    }
}
