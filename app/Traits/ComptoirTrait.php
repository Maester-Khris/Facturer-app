<?php

namespace App\Traits;
use App\Models\Comptoir;

trait ComptoirTrait {
      public static function getComptoirId($libele, $depotid){
            $comptoir = Comptoir::where('libelle',$libele)->where('depot_id',$depotid)->first();
            return  $comptoir->id;
      }
      public static function getComptoirByLibelle($libele, $depotid){
            $comptoir = Comptoir::where('libelle',$libele)->where('depot_id',$depotid)->first();
            return  $comptoir;
      }
}