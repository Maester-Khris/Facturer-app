<?php

namespace App\Traits;
use App\Models\Journalachat;

trait JournalachatTrait {

      public static function getMontantFacture($idfac){
            $journal = Journalachat::where('facture_id',$idfac)->select('montant')->first();
            return $journal->montant;
      }
}