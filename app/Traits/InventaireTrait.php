<?php

namespace App\Traits;
use App\Models\Inventaire;

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
            return $invs;
      }
}