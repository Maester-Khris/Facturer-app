<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         DB::table('depots')->insert([
            [
             'id' => 1,
             'nom_depot' => "Sainte Grace",
             'telephone' => '(+237) 98643595',
             'delai_reglement' => 4,
            ],
         ]);
    }
}
