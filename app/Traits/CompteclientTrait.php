<?php

namespace App\Traits;
use App\Models\Compteclient;

trait CompteclientTrait {
      
      public static function getTotalCredit($client_id){
            $total = Compteclient::where('client_id',$client_id)->sum('credit');
            return $total;
      }
  
      public static function getTotalDebit($client_id){
            $total = Compteclient::where('client_id',$client_id)->sum('debit');
            return $total;
      }
}