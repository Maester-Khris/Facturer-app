<?php

namespace App\Traits;
use App\Models\Facture;

trait FactureTrait {
      public static function getFacList($id_depot){
            $facs = Facture::with(['fournisseur' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])->orderBy('date_facturation','desc')->get();

            return $facs;
      }

      public static function getFacFourniList($id_depot, $id_fourni){
            $facs = Facture::with(['fournisseur' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])
                  ->where('fournisseur_id',$id_fourni)
                  ->get();

            return $facs;
      }

      public static function getByCodeFac($codefac){
            $fac = Facture::where('code_facture',$codefac)->first();
            return $fac;
      }

      public static function getByStatus(){
            $fac = Facture::with('fournisseur')
                  ->where('statut',false)->get();
                  
            return $fac;
      }
}