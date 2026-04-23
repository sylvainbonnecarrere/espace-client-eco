<?php

namespace Database\Seeders;

use App\Models\Consumption;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Contract;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On crée un utilisateur de test qu'on pourra utiliser pour se connecter
        $testUser = User::factory()->create([
            'name' => 'Sylvain Admin',
            'email' => 'sylvain@example.com',
            'password' => bcrypt('password'),
        ]);

        // On génère 10 autres utilisateurs aléatoires
        $users = User::factory(10)->create();
        $users->push($testUser); // On ajoute l'utilisateur principal à la boucle

        // Pour chaque utilisateur, on crée entre 1 et 3 contrats
        foreach ($users as $user) {
            $contracts = Contract::factory(rand(1, 3))->create([
                'user_id' => $user->id,
            ]);

            // Pour chaque contrat, on génère un an d'historique de consommation
            foreach ($contracts as $contract) {
                for ($i = 0; $i < 12; $i++) {
                    Consumption::factory()->create([
                        'contract_id' => $contract->id,
                        'month' => now()->subMonths($i)->format('Y-m'),
                    ]);
                }
            }
        }
    }
}
