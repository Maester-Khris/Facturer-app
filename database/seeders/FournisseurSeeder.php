<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FournisseurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('fournisseurs')->insert([
            [
                'id' => 1,
                'depot_id' => 1,
                'nom' => 'Mr Nzali',
                'prenom' => 'Francois',
                'telephone' => '+237 75843976',
                'solde' => 0,
                'numero_fournisseur' => 'Four001',
                'type_fournisseur' => 'gros',
            ],
            [
                'id' => 2,
                'depot_id' => 1,
                'nom' => 'Ndengue',
                'prenom' => 'Rodrigue',
                'telephone' => '+237 56982345',
                'solde' => 0,
                'numero_fournisseur' => 'Four002',
                'type_fournisseur' => 'semi-gros',
            ],
        ]);
    }
}
