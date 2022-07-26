<?php

namespace App\Traits;
use App\Models\Vente;
use Carbon\Carbon;

trait VenteTrait {

      public static function getVenteByDepot($code,$id_depot){ 
            $vente = Vente::where('code_vente',$code)
            ->with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])
            ->first();
            return $vente;
      }
      public static function getAllVentesByDepot($id_depot){ 
            $ventes = Vente::with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])
            ->get();
            return $ventes;
      }

      public static function countVentes($id_depot){
            $count = Vente::with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])->count();
            return $count;
      }

      public static function getByCode($codevente){
            $vente = Vente::where('code_vente',$codevente)->first();
            return $vente;
      }

      public static function unpaidVente($id_depot){
            $ventes = Vente::with(['client' => function($query) use ($id_depot){
                        $query->where('depot_id', $id_depot);
                  }])
                  ->where('statut',false)->get();
            return $ventes;
      }

      public static function paidVenteByDepot($id_depot, $periode_min, $periode_max){
            $ventes = Vente::with(['client' => function($query) use ($id_depot, $periode_min, $periode_max){
                        $query->where('depot_id', $id_depot);
                  }])
                  ->where('statut',true)
                  ->whereBetween('date_operation', [$periode_min, Carbon::parse($periode_max)->endOfDay()])->get();
            return $ventes;
      }

      // will help to trace client regularity: pour un client 
      public static function ListVentePerClient($id_depot, $id_client){
            $ventes = Vente::with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])
            ->where('client_id',$id_client)
            ->get();
            return $ventes;
      }
}