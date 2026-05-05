<?php

namespace Database\Seeders;

use App\Models\Piece;
use Illuminate\Database\Seeder;

class PiecesSeeder extends Seeder
{
    public function run(): void
    {
        $pieces = [
            // Freins (categorie_id=1)
            ['reference' => 'FRE-001', 'nom' => 'Plaquettes de frein avant',       'categorie_id' => 1, 'marque_id' => 6, 'prix_achat' => 18.00,  'prix_vente' => 35.00,  'stock' => 25, 'seuil_alerte' => 5],
            ['reference' => 'FRE-002', 'nom' => 'Plaquettes de frein arrière',      'categorie_id' => 1, 'marque_id' => 6, 'prix_achat' => 15.00,  'prix_vente' => 29.00,  'stock' => 20, 'seuil_alerte' => 5],
            ['reference' => 'FRE-003', 'nom' => 'Disque de frein avant',            'categorie_id' => 1, 'marque_id' => 6, 'prix_achat' => 28.00,  'prix_vente' => 55.00,  'stock' => 12, 'seuil_alerte' => 4],
            ['reference' => 'FRE-004', 'nom' => 'Disque de frein arrière',          'categorie_id' => 1, 'marque_id' => 6, 'prix_achat' => 24.00,  'prix_vente' => 48.00,  'stock' => 10, 'seuil_alerte' => 4],
            ['reference' => 'FRE-005', 'nom' => 'Liquide de frein DOT4 (500ml)',    'categorie_id' => 1, 'marque_id' => 1, 'prix_achat' => 4.50,   'prix_vente' => 9.90,   'stock' => 30, 'seuil_alerte' => 10],
            ['reference' => 'FRE-006', 'nom' => 'Étrier de frein avant gauche',     'categorie_id' => 1, 'marque_id' => 6, 'prix_achat' => 45.00,  'prix_vente' => 89.00,  'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'FRE-007', 'nom' => 'Câble de frein à main',            'categorie_id' => 1, 'marque_id' => 8, 'prix_achat' => 12.00,  'prix_vente' => 24.00,  'stock' => 8,  'seuil_alerte' => 3],

            // Filtres (categorie_id=2)
            ['reference' => 'FIL-001', 'nom' => 'Filtre à huile',                   'categorie_id' => 2, 'marque_id' => 5, 'prix_achat' => 4.00,   'prix_vente' => 8.50,   'stock' => 50, 'seuil_alerte' => 15],
            ['reference' => 'FIL-002', 'nom' => 'Filtre à air',                     'categorie_id' => 2, 'marque_id' => 5, 'prix_achat' => 6.00,   'prix_vente' => 13.00,  'stock' => 40, 'seuil_alerte' => 10],
            ['reference' => 'FIL-003', 'nom' => 'Filtre à carburant',               'categorie_id' => 2, 'marque_id' => 5, 'prix_achat' => 8.00,   'prix_vente' => 16.00,  'stock' => 25, 'seuil_alerte' => 8],
            ['reference' => 'FIL-004', 'nom' => 'Filtre d\'habitacle (pollen)',     'categorie_id' => 2, 'marque_id' => 5, 'prix_achat' => 5.00,   'prix_vente' => 11.00,  'stock' => 35, 'seuil_alerte' => 10],
            ['reference' => 'FIL-005', 'nom' => 'Kit filtre révision (huile+air+habitacle)', 'categorie_id' => 2, 'marque_id' => 5, 'prix_achat' => 14.00, 'prix_vente' => 28.00, 'stock' => 20, 'seuil_alerte' => 5],

            // Moteur (categorie_id=3)
            ['reference' => 'MOT-001', 'nom' => 'Huile moteur 5W40 (5L)',           'categorie_id' => 3, 'marque_id' => 1, 'prix_achat' => 18.00,  'prix_vente' => 38.00,  'stock' => 30, 'seuil_alerte' => 10],
            ['reference' => 'MOT-002', 'nom' => 'Courroie de distribution',         'categorie_id' => 3, 'marque_id' => 10,'prix_achat' => 22.00,  'prix_vente' => 45.00,  'stock' => 15, 'seuil_alerte' => 4],
            ['reference' => 'MOT-003', 'nom' => 'Kit courroie de distribution',     'categorie_id' => 3, 'marque_id' => 10,'prix_achat' => 55.00,  'prix_vente' => 110.00, 'stock' => 8,  'seuil_alerte' => 2],
            ['reference' => 'MOT-004', 'nom' => 'Bougie d\'allumage (unité)',       'categorie_id' => 3, 'marque_id' => 4, 'prix_achat' => 3.50,   'prix_vente' => 7.90,   'stock' => 60, 'seuil_alerte' => 20],
            ['reference' => 'MOT-005', 'nom' => 'Joint de culasse',                 'categorie_id' => 3, 'marque_id' => 8, 'prix_achat' => 35.00,  'prix_vente' => 70.00,  'stock' => 5,  'seuil_alerte' => 2],
            ['reference' => 'MOT-006', 'nom' => 'Courroie accessoires (poly-V)',    'categorie_id' => 3, 'marque_id' => 10,'prix_achat' => 14.00,  'prix_vente' => 28.00,  'stock' => 18, 'seuil_alerte' => 5],
            ['reference' => 'MOT-007', 'nom' => 'Liquide de refroidissement (1L)',  'categorie_id' => 3, 'marque_id' => 1, 'prix_achat' => 3.00,   'prix_vente' => 7.00,   'stock' => 40, 'seuil_alerte' => 10],

            // Électrique (categorie_id=4)
            ['reference' => 'ELE-001', 'nom' => 'Batterie 60Ah / 540A',            'categorie_id' => 4, 'marque_id' => 1, 'prix_achat' => 55.00,  'prix_vente' => 110.00, 'stock' => 8,  'seuil_alerte' => 2],
            ['reference' => 'ELE-002', 'nom' => 'Batterie 72Ah / 680A',            'categorie_id' => 4, 'marque_id' => 1, 'prix_achat' => 72.00,  'prix_vente' => 140.00, 'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'ELE-003', 'nom' => 'Alternateur reconditionné',        'categorie_id' => 4, 'marque_id' => 2, 'prix_achat' => 90.00,  'prix_vente' => 175.00, 'stock' => 3,  'seuil_alerte' => 1],
            ['reference' => 'ELE-004', 'nom' => 'Démarreur reconditionné',          'categorie_id' => 4, 'marque_id' => 2, 'prix_achat' => 85.00,  'prix_vente' => 165.00, 'stock' => 3,  'seuil_alerte' => 1],
            ['reference' => 'ELE-005', 'nom' => 'Bobine d\'allumage',              'categorie_id' => 4, 'marque_id' => 1, 'prix_achat' => 28.00,  'prix_vente' => 56.00,  'stock' => 10, 'seuil_alerte' => 3],
            ['reference' => 'ELE-006', 'nom' => 'Ampoule H7 (paire)',              'categorie_id' => 4, 'marque_id' => 1, 'prix_achat' => 6.00,   'prix_vente' => 13.00,  'stock' => 25, 'seuil_alerte' => 8],
            ['reference' => 'ELE-007', 'nom' => 'Capteur ABS avant gauche',        'categorie_id' => 4, 'marque_id' => 1, 'prix_achat' => 22.00,  'prix_vente' => 44.00,  'stock' => 7,  'seuil_alerte' => 2],

            // Transmission (categorie_id=5)
            ['reference' => 'TRN-001', 'nom' => 'Kit embrayage complet',            'categorie_id' => 5, 'marque_id' => 9, 'prix_achat' => 120.00, 'prix_vente' => 240.00, 'stock' => 5,  'seuil_alerte' => 1],
            ['reference' => 'TRN-002', 'nom' => 'Disque d\'embrayage',             'categorie_id' => 5, 'marque_id' => 9, 'prix_achat' => 45.00,  'prix_vente' => 90.00,  'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'TRN-003', 'nom' => 'Butée d\'embrayage',              'categorie_id' => 5, 'marque_id' => 9, 'prix_achat' => 20.00,  'prix_vente' => 40.00,  'stock' => 8,  'seuil_alerte' => 2],
            ['reference' => 'TRN-004', 'nom' => 'Huile boîte de vitesses (1L)',     'categorie_id' => 5, 'marque_id' => 1, 'prix_achat' => 8.00,   'prix_vente' => 18.00,  'stock' => 20, 'seuil_alerte' => 5],
            ['reference' => 'TRN-005', 'nom' => 'Rotule de direction',              'categorie_id' => 5, 'marque_id' => 8, 'prix_achat' => 14.00,  'prix_vente' => 28.00,  'stock' => 12, 'seuil_alerte' => 4],

            // Suspension (categorie_id=6)
            ['reference' => 'SUS-001', 'nom' => 'Amortisseur avant gauche',         'categorie_id' => 6, 'marque_id' => 1, 'prix_achat' => 40.00,  'prix_vente' => 80.00,  'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'SUS-002', 'nom' => 'Amortisseur avant droit',          'categorie_id' => 6, 'marque_id' => 1, 'prix_achat' => 40.00,  'prix_vente' => 80.00,  'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'SUS-003', 'nom' => 'Ressort de suspension avant',      'categorie_id' => 6, 'marque_id' => 8, 'prix_achat' => 22.00,  'prix_vente' => 45.00,  'stock' => 8,  'seuil_alerte' => 2],
            ['reference' => 'SUS-004', 'nom' => 'Silent-bloc de triangle',          'categorie_id' => 6, 'marque_id' => 8, 'prix_achat' => 8.00,   'prix_vente' => 18.00,  'stock' => 15, 'seuil_alerte' => 5],
            ['reference' => 'SUS-005', 'nom' => 'Roulement de roue avant',          'categorie_id' => 6, 'marque_id' => 7, 'prix_achat' => 25.00,  'prix_vente' => 50.00,  'stock' => 10, 'seuil_alerte' => 3],

            // Refroidissement (categorie_id=8)
            ['reference' => 'REF-001', 'nom' => 'Radiateur de refroidissement',     'categorie_id' => 8, 'marque_id' => 8, 'prix_achat' => 65.00,  'prix_vente' => 130.00, 'stock' => 4,  'seuil_alerte' => 1],
            ['reference' => 'REF-002', 'nom' => 'Thermostat moteur',                'categorie_id' => 8, 'marque_id' => 8, 'prix_achat' => 12.00,  'prix_vente' => 25.00,  'stock' => 12, 'seuil_alerte' => 4],
            ['reference' => 'REF-003', 'nom' => 'Pompe à eau',                      'categorie_id' => 8, 'marque_id' => 8, 'prix_achat' => 30.00,  'prix_vente' => 60.00,  'stock' => 6,  'seuil_alerte' => 2],
            ['reference' => 'REF-004', 'nom' => 'Durite de refroidissement supérieure', 'categorie_id' => 8, 'marque_id' => 8, 'prix_achat' => 10.00, 'prix_vente' => 22.00, 'stock' => 8, 'seuil_alerte' => 3],
        ];

        foreach ($pieces as $data) {
            Piece::create($data);
        }
    }
}
