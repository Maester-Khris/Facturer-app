<?php

namespace App\Traits;
use App\Models\Mouvementstock;
use App\Models\Stockdepot;
use Illuminate\Support\Facades\DB;

trait MouvementstockTrait {
      public static function allMouvement(){
            $mvts= Mouvementstock::with('marchandise')
            ->join("stockdepots","mouvementstocks.stockdepot_id","=","stockdepots.id")
            ->join("depots","stockdepots.depot_id","=","depots.id")
            ->select("mouvementstocks.*","depots.nom_depot")
            ->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);
            return $new_mvts;
      }

      public static function getMouvementOperations($id_depot){
            $stocks = Stockdepot::where("depot_id", $id_depot)->get();
            $stocksid = $stocks->map(function($item) { return $item->id; } );

            $mvts= Mouvementstock::with('marchandise')->whereIn('stockdepot_id',$stocksid)->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);

            return $new_mvts;
      }

      public static function getAllMouvements(){
            $mvts= Mouvementstock::with('marchandise')->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);
            return $new_mvts->count();
      }

      public static function getAllMvts(){
            $mvts= Mouvementstock::with('marchandise')->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);
            return $new_mvts;
      }

      public static function getMouvementTransfertOperations($id_depot){
            $stocks = Stockdepot::where("depot_id", $id_depot)->get();
            $stocksid = $stocks->map(function($item) { return $item->id; } );

            $mvts= Mouvementstock::with('marchandise')->where('type_mouvement','Transfert')->whereIn('stockdepot_id',$stocksid)->get();
            $mvts_unique = collect($mvts)->unique('reference_mouvement')->all();
            $new_mvts = collect($mvts_unique);

            return $new_mvts;
      }

      public static function getMarchandiseMvt($code_mouvement){
            $details = Mouvementstock::with('marchandise')->where('reference_mouvement',$code_mouvement)->get();
            return $details;
      }
}
