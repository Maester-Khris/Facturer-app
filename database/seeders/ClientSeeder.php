<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('clients')->insert([
            [
                'id' => 1,
                'depot_id' => 1,
                'nom_complet' => 'Ngane Eboutou',
                'telephone' => '+237 98764356',
                'solde' => 0,
                'numero_client' => 'client001',
                'type_client' => 'regulier',
                'type_paiement' => 'cheque', 
                'multi_depot_caisses' => true
            ],
            [
                'id' => 2,
                'depot_id' => 1,
                'nom_complet' => 'Tarovsky Tall',
                'telephone' => '+237 90776353',
                'solde' => 0,
                'numero_client' => 'client002',
                'type_client' => 'regulier',
                'type_paiement' => 'espece', 
                'multi_depot_caisses' => false
            ],
        ]);
    }
}
