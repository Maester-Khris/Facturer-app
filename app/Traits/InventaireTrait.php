<?php

namespace App\Traits;
use App\Models\Inventaire;
use App\Models\Stockdepot;
use Illuminate\Support\Facades\DB;

trait InventaireTrait {
      public static function getInventory($id_depot){
            $stocks = Stockdepot::where("depot_id", $id_depot)->get();
            $stocksid = $stocks->map(function($item) { return $item->id; } );
            $invs = Inventaire::with('marchandise')->whereIn('stockdepot_id',$stocksid)->get();
            $final = collect($invs)->unique('reference_inventaire')->all();
            return $final;
      }

      public static function getMarchandiseIvt($id_depot, $code_inventaire){
            $stocks = Stockdepot::where("depot_id", $id_depot)->get();
            $stocksid = $stocks->map(function($item) { return $item->id; } );
            $details = Inventaire::with('marchandise')->where('reference_inventaire',$code_inventaire)->whereIn('stockdepot_id',$stocksid)->get();
            return $details;
      }
}