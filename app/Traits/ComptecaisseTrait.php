<?php

namespace App\Traits;
use App\Models\Comptecaisse;

trait ComptecaisseTrait {

      public static function MontantReglementFacture($codefac){
            $libele = 'Reglement facture '. $codefac;
            $montant = Comptecaisse::where('libele_operation',$libele)->sum('credit');
            if( $montant == null){
                  $montant = 0;
            }
            return $montant;
      }

      public static function MontantReglementVente($codevente){
            $libele = 'Reglement vente '. $codevente;
            $montant = Comptecaisse::where('libele_operation',$libele)->sum('debit');
            if( $montant == null){
                  $montant = 0;
            }
            return $montant;
      }
}