<?php

namespace App\Traits;
use App\Models\Facture;

trait FactureTrait {

      public static function getFactureByDepot($code, $id_depot){
            $fac = Facture::where('code_facture',$code)
            ->with(['fournisseur' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])->orderBy('date_facturation','desc')->first();

            return $fac;
      }
      public static function getAllFacturesByDepot($id_depot){
            $facs = Facture::with(['fournisseur' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])->orderBy('date_facturation','desc')->get();
            $facs = $facs->filter(function($item){
                  if($item->fournisseur) return $item;
            });
            return $facs;
      }

      public static function countFactures($id_depot){
            $facs = Facture::getAllFacturesByDepot($id_depot);
            $count = $facs->count();
            return $count;
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

      public static function getFournisseurAchat($codefac, $depot){
            $fourni = Facture::where("code_facture",$codefac)
                  ->join("fournisseurs","factures.fournisseur_id","=","fournisseurs.id")
                  ->where("fournisseurs.depot_id",$depot)
                  ->select("fournisseurs.nom_complet")
                  ->first();

            return $fourni;
      }

      public static function unSoldedFactures($id_depot){
            $facs = Facture::with(['fournisseur' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])
                  ->join('journalachats','journalachats.facture_id',"=",'factures.id')
                  ->where('statut',false)
                  ->select('factures.*')
                  ->get();
            $facs = $facs->filter(function($item){
                  if($item->fournisseur) return $item;
            });
            return $facs;
      }
}