<?php
namespace Database\Seeders;
use App\Models\{User, Marque, Categorie};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        // Compte admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@segh.fr',
            'password' => Hash::make('Segh2026!'),
            'role'     => 'admin',
        ]);

        // Marques pièces
        foreach (['BOSCH','VALEO','CONTINENTAL','NGK','MANN FILTER','BREMBO','SKF','FEBI','LUK','GATES'] as $nom) {
            Marque::create(['nom' => $nom]);
        }

        // Catégories
        foreach ([
            ['nom' => 'Freins',        'couleur' => '#EF4444'],
            ['nom' => 'Filtres',       'couleur' => '#F59E0B'],
            ['nom' => 'Moteur',        'couleur' => '#10B981'],
            ['nom' => 'Électrique',    'couleur' => '#3B82F6'],
            ['nom' => 'Transmission',  'couleur' => '#8B5CF6'],
            ['nom' => 'Suspension',    'couleur' => '#EC4899'],
            ['nom' => 'Carrosserie',   'couleur' => '#6B7280'],
            ['nom' => 'Refroidissement','couleur' => '#06B6D4'],
        ] as $cat) {
            Categorie::create($cat);
        }
    }
}
