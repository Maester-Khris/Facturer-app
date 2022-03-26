<?php

namespace App\Traits;
use App\Models\Journalvente;

trait JournalventeTrait {

      public static function getMontantFacture($idvente){
            $journal = Journalvente::where('vente_id',$idvente)->select('montant')->first();
            return $journal->montant;
      }
}