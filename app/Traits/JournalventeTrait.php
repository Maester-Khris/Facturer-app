<?php

namespace App\Traits;
use App\Models\Journalvente;

trait JournalventeTrait {

      public static function getMontantFacture($idvente){
            // dd($idvente);
            $journal = Journalvente::where('vente_id',$idvente)->select('montant')->first();
            // dd($journal);
            return $journal->montant;
      }
}