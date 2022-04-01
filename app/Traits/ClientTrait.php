<?php

namespace App\Traits;
use App\Models\Client;
use App\Models\Vente;
use App\Models\Comptecaisse;

trait ClientTrait {
      public static function getClientId($nom, $depotid){
            $client = Client::where('nom',$nom)->where('depot_id',$depotid)->first();
            return  $client->id;
      }

      public static function retrieveSold($client){
            $client = Client::where('nom', $client)->first();
            return $client->solde;
      }

      public static function getClient($nom, $depotid){
            $client = Client::where('nom',$nom)->where('depot_id',$depotid)->first();
            return  $client;
      }

      public static function allDepotClient($depotid){
            $clients = Client::where('depot_id',$depotid)->orderBy('nom','asc')->get();
            return  $clients;
      }

      public static function ClientTransactions($id_depot, $id_client){
             /**
             * get la liste des vente where if client with client
             * dans vente on prend: montant, date facturation, codevente
             * pour chaque vente 
             *    get all codecase where libele like codevente, date, debit
            */
            $ventes = Vente::ListVentePerClient($id_depot, $id_client);
            $activities = collect();

            foreach($ventes as $vente){
                  $ligne = [
                        'client'  => $vente->client->nom,
                        'codevente'  => $vente->code_vente,
                        'total'  => $vente->montant_net,
                        'date_operation'  => $vente->date_operation,
                        'credit'  => 0,
                        'debit'  => $vente->montant_net
                  ];
                  $activities->push($ligne);

                  $caisses = Comptecaisse::where('libele_operation','like','%'. $vente->code_vente)->get();
                  if($caisses != null){
                        foreach($caisses as $caisse){
                              $ligne1 = [
                                    'client'  => $vente->client->nom,
                                    'codevente'  => $vente->code_vente,
                                    'total'  => $vente->montant_net,
                                    'date_operation'  => $caisse->date_operation,
                                    'credit'  => $caisse->debit,
                                    'debit'  => 0
                              ];
                              $activities->push($ligne1);
                        }
                  }
            }
            return $activities;
      }
}