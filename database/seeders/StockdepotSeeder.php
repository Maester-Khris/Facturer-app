<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StockdepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('stockdepots')->insert([
            [
                'id' => 1,
                'depot_id' => 1,
                'marchandise_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 50,
                'quantite_stock' => 21,
            ],
            [
                'id' => 2,
                'depot_id' => 2,
                'marchandise_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 50,
                'quantite_stock' => 21,
            ],
            [
                'id' => 3,
                'depot_id' => 1,
                'marchandise_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 100,
                'quantite_stock' => 15,
            ],
            [
                'id' => 4,
                'depot_id' => 2,
                'marchandise_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 100,
                'quantite_stock' => 15,
            ],
            [
                'id' => 5,
                'depot_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 80,
                'marchandise_id' => 3,
                'quantite_stock' => 23,
            ],
            [
                'id' => 6,
                'depot_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 80,
                'marchandise_id' => 3,
                'quantite_stock' => 23,
            ],
            [
                'id' => 7,
                'depot_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 50,
                'marchandise_id' => 4,
                'quantite_stock' => 12,
            ],
            [
                'id' => 8,
                'depot_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 50,
                'marchandise_id' => 4,
                'quantite_stock' => 12,
            ],
            [
                'id' => 9,
                'depot_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 50,
                'marchandise_id' => 5,
                'quantite_stock' => 12,
            ],
            [
                'id' => 10,
                'depot_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 50,
                'marchandise_id' => 5,
                'quantite_stock' => 12,
            ],
            [
                'id' => 11,
                'depot_id' => 1,
                'limite' => 10,
                'quantite_optimal' => 150,
                'marchandise_id' => 6,
                'quantite_stock' => 50,
            ],
            [
                'id' => 12,
                'depot_id' => 2,
                'limite' => 10,
                'quantite_optimal' => 150,
                'marchandise_id' => 6,
                'quantite_stock' => 50,
            ],
        ]);
    }
}
