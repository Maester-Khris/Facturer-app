<?php

namespace App\Traits;
use App\Models\Mouvementstock;

trait MouvementstockTrait {
      public static function getMouvementOperations($id_stockdepot){
            // $mvts= Mouvementstock::where("stockdepot_id",$id_stockdepot)
            //       ->join("marchandises","marchandises.id","=","mouvementstocks.id")
            //       ->select("mouvementstocks.reference_mouvement","mouvementstocks.type_mouvement","mouvementstocks.destination","mouvementstocks.quantite_mouvement","mouvementstocks.date_operation","marchandises.designation")
            //       ->get();

            $mvts= Mouvementstock::with('marchandise')->get();
            
            return $mvts;
      }
}
