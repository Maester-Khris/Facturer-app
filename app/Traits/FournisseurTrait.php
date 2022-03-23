<?php

namespace App\Traits;
use App\Models\Inventaire;
use App\Models\Fournisseur;
use App\Models\Facture;
use App\Models\Journalachat;
use App\Models\Comptecaisse;

trait FournisseurTrait {
      public static function getByDepot($id_depot){
            $fournisseurs = Fournisseur::where('depot_id',$id_depot)->orderBy('nom','asc')->get();
            return $fournisseurs;
      }

      public static function FournisseurTransactions($id_depot, $id_fourni){
            /**
             * get la liste des facture where fournisseur with fournis
             * dans facture on prend: montant, date facturation, cpdefacture
             * pour chaque facture 
             *    get all codecase where libele like codefacture: date, credit
            */
            $factures = Facture::getFacFourniList($id_depot, $id_fourni);
            $activities = collect();
            foreach($factures as $fac){
                  $ligne = [
                        'fournisseur'  => $fac->fournisseur->nom,
                        'codefac'  => $fac->code_facture,
                        'total'  => $fac->montant_net,
                        'date_operation'  => $fac->date_facturation,
                        'credit'  => $fac->montant_net,
                        'debit'  => 0
                  ];
                  $activities->push($ligne);
                  $pattern = 
                  $caisses = Comptecaisse::where('libele_operation','like','%'. $fac->code_facture)->get();
                  if($caisses != null){
                        foreach($caisses as $caisse){
                              $ligne1 = [
                                    'fournisseur'  => $fac->fournisseur->nom,
                                    'codefac'  => $fac->code_facture,
                                    'total'  => $fac->montant_net,
                                    'date_operation'  => $caisse->date_operation,
                                    'credit'  => 0,
                                    'debit'  => $caisse->credit
                              ];
                              $activities->push($ligne1);
                        }
                  }
            }
            return $activities;
      }
}

// $factures = Facture::join("fournisseurs","fournisseurs.id","=","factures.fournisseur_id")
//       ->where('fournisseurs.nom',$nom_fourni)      
//       ->where('fournisseurs.depot_id',$id_depot)
//       ->orderBy('fournisseurs.nom','asc')
//       ->orderBy('factures.date_facturation','asc')
//       ->select('factures.code_facture','factures.montant_total',
//             'fournisseurs.nom','fournisseurs.prenom',
//             'fournisseurs.solde', 
//             'fournisseurs.date_dernier_calcul_solde', 
//             'fournisseurs.solde')
//       ->get();

// $activites = Journalachat::with('facture')
//       ->with(['comptefournisseur.fournisseur' => function($query) use ($id_fourni) {
//             $query->where('id', $id_fourni);
//       }])
//       ->get();
// return $activites;