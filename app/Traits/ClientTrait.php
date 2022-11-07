<?php

namespace App\Traits;
use App\Models\Client;
use App\Models\Vente;
use App\Models\Comptecaisse;

trait ClientTrait {
      public static function getClient($nom_complet, $depotid){
            $client = Client::where('nom_complet',$nom_complet)->where('depot_id',$depotid)->first();
            return  $client;
      }
      public static function getClientId($nom_complet, $depotid){
            $client = Client::where('nom_complet',$nom_complet)->where('depot_id',$depotid)->first();
            return  $client->id;
      }

      public static function retrieveSold($client){
            $client = Client::where('nom_complet', $client)->first();
            return $client->solde;
      }

      public static function getClientById($clientid, $depotid){
            $client = Client::where('id',$clientid)->where('depot_id',$depotid)->first();
            return  $client;
      }

      public static function allDepotClientWithDefaults($depotid){
            $clients = Client::where('depot_id',$depotid)->orderBy('nom_complet','asc')->get();
            return  $clients;
      }
      public static function allDepotClientWithoutDefaults($depotid){
            $clients = Client::where('depot_id',$depotid)->where('nom_complet','not like','Clt%')->orderBy('nom_complet','asc')->get();
            return  $clients;
      }

      public static function getClientByDepot($client_name, $depotid){
            $clients = Client::where('depot_id',$depotid)
            ->where('nom_complet','like','%'.$client_name.'%')
            ->where('nom_complet','not like','Clt%')
            ->orderBy('nom_complet','asc')
            ->get();
            return  $clients;
      }

}