<?php

namespace App\Traits;
use App\Models\Mouvementstock;
use App\Models\Stockdepot;
use Illuminate\Support\Facades\DB;

trait MouvementstockTrait {
      public static function getMouvementOperations($id_depot){
            // $mvts= Mouvementstock::where("stockdepot_id",$id_stockdepot)
            //       ->join("marchandises","marchandises.id","=","mouvementstocks.id")
            //       ->select("mouvementstocks.reference_mouvement","mouvementstocks.type_mouvement","mouvementstocks.destination","mouvementstocks.quantite_mouvement","mouvementstocks.date_operation","marchandises.designation")
            //       ->get();
            // get tout les stockdepot
            // filter where stock.deopt = iddepot
            // filtre result where final.stodk in nes
            $mvts= Mouvementstock::with('marchandise')->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);
            $stockdepotids = $new_mvts->map(function($item){
                  return $item->stockdepot_id;
            });
            $stocks = Stockdepot::whereIn('id',$stockdepotids)->where('depot_id',$id_depot)->get();
            $final = $new_mvts->filter(function($item) use ($stocks){
                  if($stocks->contains($item->stockdepot_id)){
                        return $item;
                  }
            });
            return $final;
      }

      public static function getMouvementTransfertOperations($id_depot){
            $mvts= Mouvementstock::with('marchandise')->where('type_mouvement','Transfert')->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);
            $stockdepotids = $new_mvts->map(function($item){
                  return $item->stockdepot_id;
            });
            $stocks = Stockdepot::whereIn('id',$stockdepotids)->where('depot_id',$id_depot)->get();
            $final = $new_mvts->filter(function($item) use ($stocks){
                  if($stocks->contains($item->stockdepot_id)){
                        return $item;
                  }
            });
            return $final;
      }

      public static function getMarchandiseMvt($id_stockdepot, $code_mouvement){
            $details = Mouvementstock::with('marchandise')->where('reference_mouvement',$code_mouvement)->get();
            return $details;
      }
}
