<?php

namespace App\Traits;
use App\Models\CompteFournisseur;

trait ComptefournisseurTrait {
      
      public static function getTotalCredit($founi_id){
            $total = CompteFournisseur::where('fournisseur_id',$founi_id)->sum('credit');
            return $total;
      }
  
      public static function getTotalDebit($founi_id){
            $total = CompteFournisseur::where('fournisseur_id',$founi_id)->sum('debit');
            return $total;
      }
}