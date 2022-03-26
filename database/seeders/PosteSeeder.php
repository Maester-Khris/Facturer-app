<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('personnels')->insert([
            'id' => 1,
            'depot_id' => 1,
            'nom' => 'Mojalez',
            'prenom' => 'Marius Baldwin',
            'sexe' => 'F',
            'telephone' => '(+237) 98643595',
            'email' => 'Marius@gmail.com',
            'cni' => '23436576787889',
            'date_embauche' => '2021-12-26',
            'type_contrat' => 'CDD',
            'poste' => 'Caissier',
            'statut' => 'Actif',
            'matricule' => 'PNL001',
            'matricule_cnps' => 'PNLCNP001',
        ]);

        DB::table('caisses')->insert([
            'id' => 1,
            'numero_caisse' => 'CAI001',
            'libelle' => 'Comptoir principal',
        ]);

        DB::table('comptoirs')->insert([
            'id' => 1,
            'depot_id' => 1,
            'personnel_id' => 1,
            'caisse_id' => 1,
            'libelle' => 'Comptoir principal',
        ]);
    }
}
