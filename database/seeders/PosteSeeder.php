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
            'nom_complet' => 'Mojalez Marius Baldwin',
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
        // DB::table('ventes')->insert([
        //     [
        //      'id' => 1,
        //      'client_id' => 1,
        //      'code_vente' => 'VN0001',
        //      'montant_remise' => 1000,
        //      'montant_total' => 10000,
        //      'montant_net' => 11000,
        //      'indicatif' => 1,
        //      'date_operation' =>  "2020/12/09 12:03:00"
        //     ],
        // ]);
        // DB::table('detailtransactions')->insert([
        //     [
        //      'id' => 1,
        //      'reference_transaction' =>"VN0001",
        //      'reference_marchandise' => "REF0003",
        //      'quantite' => 12
        //     ],
        //     [
        //         'id' => 2,
        //         'reference_transaction' =>"VN0001",
        //         'reference_marchandise' => "REF0004",
        //         'quantite' => 10
        //     ],
        //     [
        //         'id' => 3,
        //         'reference_transaction' =>"VN0001",
        //         'reference_marchandise' => "REF0005",
        //         'quantite' => 31
        //     ],
        // ]);
        // DB::table('tickets')->insert([
        //     [
        //      'id' => 1,
        //      'code_ticket' =>"TC0001",
        //      'comptoir_id' => 1,
        //      'reference_marchandise' => 'REF0004',
        //      'quantite' => 12,
        //      'type_vente' => 'gros',
        //      'prix_vente' => 12000,
        //     ],
        // ]);
    }
}
