<?php

namespace App\Traits;
use App\Models\Depot;

trait DepotTrait {
      public static function getDepotById($depotid){
            $depot = Depot::where('id',$depotid)->first();
            return  $depot;
      }
      public static function getDepotId($depot){
            $depot = Depot::where('nom_depot',$depot)->first();
            return  $depot->id;
      }

}