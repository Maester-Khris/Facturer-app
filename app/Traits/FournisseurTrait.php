<?php

namespace App\Traits;
use App\Models\Inventaire;
use App\Models\Fournisseur;
use App\Models\Facture;
use App\Models\Journalachat;
use App\Models\Comptecaisse;

trait FournisseurTrait {

      public static function getFournisseur($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni;
      }
      
      public static function getFournisseurId($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni->id;
      }

      public static function getFournisseurSolde($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni->solde;
      }

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
                        'fournisseur'  => $fac->fournisseur->nom_complet,
                        'codefac'  => $fac->code_facture,
                        'total'  => $fac->montant_net,
                        'date_operation'  => $fac->date_facturation,
                        'credit'  => $fac->montant_net,
                        'debit'  => 0
                  ];
                  $activities->push($ligne);
                  
                  $caisses = Comptecaisse::where('libele_operation','like','%'. $fac->code_facture)->get();
                  if($caisses != null){
                        foreach($caisses as $caisse){
                              $ligne1 = [
                                    'fournisseur'  => $fac->fournisseur->nom_complet,
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
