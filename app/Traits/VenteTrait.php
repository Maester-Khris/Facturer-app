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
            $ventes = $ventes->filter(function($item){
                  if($item->client) return $item;
            });
            return $ventes;
      }

      public static function countVentes($id_depot){
            $ventes = Vente::getAllVentesByDepot($id_depot);
            $count =  $ventes->count();
            return $count;
      }

      public static function getByCode($codevente){
            $vente = Vente::where('code_vente',$codevente)->first();
            return $vente;
      }

      public static function getClientVente($codevente, $depot){
            $client = Vente::where("code_vente",$codevente)
                  ->join("clients","ventes.client_id","=","clients.id")
                  ->where("clients.depot_id",$depot)
                  ->select("clients.nom_complet")
                  ->first();

            return $client;
      }

      public static function unpaidVente($id_depot){
            $ventes = Vente::with(['client' => function($query) use ($id_depot){
                  $query->where('depot_id', $id_depot);
            }])
            ->join('journalventes','journalventes.vente_id',"=",'ventes.id')
            ->where('statut',false)
            ->select('ventes.*')
            ->get();
            $ventes = $ventes->filter(function($item){
                  if($item->client) return $item;
            });
            // dd($ventes);
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