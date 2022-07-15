<?php

namespace App\Traits;
use App\Models\Inventaire;
use Illuminate\Support\Facades\DB;

trait InventaireTrait {
      public static function getInventory($id_stockdepot){
            // pour chaque articles on affiche ref, designation, qte en stock
            // date de dernier reajustement, difference reajustement
            // note: un reajustement est un mouvement de sorti et aussi une ligne dans l'inventaire
            //    -> creer une novelle ligne inventaire a chaque reajustement dans situation depot

            // $invs = Inventaire::where("stockdepot_id",$id_stockdepot)
            //       ->join("stockdepots","stockdepots.marchandise_id","=","inventaires.marchandise_id")
            //       ->select("inventaires.*","stockdepots.quantite_stock")
            //       ->get();
            
            $invs = Inventaire::with('marchandise')->get();
            $final = collect($invs)->unique('reference_inventaire')->all();
            return $final;
      }

      public static function getMarchandiseIvt($id_stockdepot, $code_inventaire){
            $details = Inventaire::with('marchandise')->where('reference_inventaire',$code_inventaire)->get();
            return $details;
      }
}