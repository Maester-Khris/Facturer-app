<?php

namespace App\Traits;
use App\Models\Mouvementstock;
use Illuminate\Support\Facades\DB;

trait MouvementstockTrait {
      public static function getMouvementOperations($id_stockdepot){
            // $mvts= Mouvementstock::where("stockdepot_id",$id_stockdepot)
            //       ->join("marchandises","marchandises.id","=","mouvementstocks.id")
            //       ->select("mouvementstocks.reference_mouvement","mouvementstocks.type_mouvement","mouvementstocks.destination","mouvementstocks.quantite_mouvement","mouvementstocks.date_operation","marchandises.designation")
            //       ->get();

            $mvts= Mouvementstock::with('marchandise')->get();
            $final = collect($mvts)->unique('reference_mouvement')->all();
            return $final;
      }

      public static function getMarchandiseMvt($id_stockdepot, $code_mouvement){
            $details = Mouvementstock::with('marchandise')->where('reference_mouvement',$code_mouvement)->get();
            return $details;
      }
}
