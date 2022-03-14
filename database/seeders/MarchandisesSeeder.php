<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MarchandisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('marchandises')->insert([
                 [
                   'id' => 1,
                   'reference' => "REF0001",
                   'designation' => 'Barre de choco Delisso',
                   'prix_achat' => 1500,
                   'dernier_prix_achat' => 1750,
                   'prix_vente_detail' => 2200,
                   'prix_vente_gros' => 2000,
                   'unite_achat' => 'Carton',
                   'cmup' => 225,
                   'conditionement' => "carton",
                   'quantité_conditionement' => 20,
                ],
                [
                  'id' => 2,
                  'reference' => "REF0002",
                  'designation' => 'Biscuit Fourré Amour',
                  'prix_achat' => 1300,
                  'dernier_prix_achat' => 1550,
                  'prix_vente_detail' => 1800,
                  'prix_vente_gros' => 1600,
                  'unite_achat' => 'Carton',
                  'cmup' => 200,
                  'conditionement' => "carton",
                  'quantité_conditionement' => 30,
               ],
               [
                 'id' => 3,
                 'reference' => "REF0003",
                 'designation' => 'Boite de chocolat Mambo Bleu',
                 'prix_achat' => 1700,
                 'dernier_prix_achat' => 1900,
                 'prix_vente_detail' => 200,
                 'prix_vente_gros' => 175,
                 'unite_achat' => 'Boite',
                 'cmup' => 150,
                 'conditionement' => "Boite",
                 'quantité_conditionement' => 7,
              ],
              [
                'id' => 4,
                'reference' => "REF0004",
                'designation' => 'Boite de Biscuit Biscout',
                'prix_achat' => 1500,
                'dernier_prix_achat' => 1750,
                'prix_vente_detail' => 125,
                'prix_vente_gros' => 100,
                'unite_achat' => 'Boite',
                'cmup' => 125,
                'conditionement' => "Boite",
                'quantité_conditionement' => 20,
             ],
             [
               'id' => 5,
               'reference' => "REF0005",
               'designation' => 'Boite de Gateau Monblanc',
               'prix_achat' => 1600,
               'dernier_prix_achat' => 1750,
               'prix_vente_detail' => 250,
               'prix_vente_gros' => 200,
               'unite_achat' => 'Boite',
               'cmup' => 175,
               'conditionement' => "Boite",
               'quantité_conditionement' => 10,
            ],
            [
              'id' => 6,
              'reference' => "REF0006",
              'designation' => 'Boite de Bonbon Secoué',
              'prix_achat' => 1200,
              'dernier_prix_achat' => 1350,
              'prix_vente_detail' => 50,
              'prix_vente_gros' => 50,
              'unite_achat' => 'Boite',
              'cmup' => 125,
              'conditionement' => "Boite",
              'quantité_conditionement' => 5,
           ]
        ]);
    }
}
