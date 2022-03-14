<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MouvementstockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('mouvementstocks')->insert([
              [
               'id' => 1,
               'marchandise_id' => 2,
               'stockdepot_id' => 1,
               'reference_mouvement' => "Mouv001",
               'type_mouvement' => "Entrée",
               'destination' => null,
               'quantite_mouvement' => 30,
               'date_operation' => "2020/12/09",
             ],
             [
              'id' => 2,
              'marchandise_id' => 6,
              'stockdepot_id' => 1,
              'reference_mouvement' => "Mouv002",
              'type_mouvement' => "Transfert",
              'destination' => "Bon Burger",
              'quantite_mouvement' => 50,
              'date_operation' => "2021/02/01",
            ],
            [
             'id' => 3,
             'marchandise_id' => 3,
             'stockdepot_id' => 1,
             'reference_mouvement' => "Mouv003",
             'type_mouvement' => "Sortie",
             'destination' => null,
             'quantite_mouvement' => 17,
             'date_operation' => "2021/09/30",
           ],
           [
            'id' => 4,
            'marchandise_id' => 5,
            'stockdepot_id' => 1,
            'reference_mouvement' => "Mouv004",
            'type_mouvement' => "Sortie",
            'destination' => "Depot Central",
            'quantite_mouvement' => 10,
            'date_operation' => "2021/12/23",
         ],
        ]);
    }
}
