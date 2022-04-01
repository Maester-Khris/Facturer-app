<?php

namespace App\Traits;
use App\Models\Vente;

trait VenteTrait {

      public static function allVente($id_depot){
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

      // will help to trace client regularity
      public static function ListVentePerClient($id_depot, $id_client){
            $ventes = Vente::with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])
            ->where('client_id',$id_client)
            ->get();
            return $ventes;
      }
}