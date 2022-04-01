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
               'reference_mouvement' => "MOV001",
               'type_mouvement' => "Entrée",
               'destination' => null,
               'quantite_mouvement' => 30,
               'date_operation' => "2020/12/09 12:03:00",
             ],
             [
              'id' => 2,
              'marchandise_id' => 6,
              'stockdepot_id' => 1,
              'reference_mouvement' => "MOV002",
              'type_mouvement' => "Transfert",
              'destination' => "Bon Burger",
              'quantite_mouvement' => 50,
              'date_operation' => "2021/02/01 10:05:28",
            ],
            [
             'id' => 3,
             'marchandise_id' => 3,
             'stockdepot_id' => 1,
             'reference_mouvement' => "MOV003",
             'type_mouvement' => "Sortie",
             'destination' => null,
             'quantite_mouvement' => 17,
             'date_operation' => "2021/09/30 11:03:02",
           ],
           [
            'id' => 4,
            'marchandise_id' => 5,
            'stockdepot_id' => 1,
            'reference_mouvement' => "MOV004",
            'type_mouvement' => "Sortie",
            'destination' => "Depot Central",
            'quantite_mouvement' => 10,
            'date_operation' => "2021/12/23 18:03:43",
         ],
        ]);
    }
}
