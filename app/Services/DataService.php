<?php
namespace App\Services;

use App\Models\Marchandise;
use App\Models\Client;
use App\Models\Stockdepot;
use App\Models\Detailtransactions;

class DataService{

      public static function Marchandisesuggestion($march_name){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->limit(3)
                ->get();
            return $marchs;
      }
      public static function Clientsuggestion($client_name){
            $marchs = Client::where('nom_complet','LIKE','%'.$client_name.'%')
                ->limit(3)
                ->get();
            return $marchs;
      }

      public static function Marchandisestockinfo($march_name){
            $marchid = Marchandise::getMarchId($march_name);
            $marchname = Marchandise::getMarch($march_name);
            $march_stock_info = Stockdepot::marchandiseStockInfo($marchid);
            return  [$march_stock_info->quantite_stock,  $marchname->reference];
      }

      public static function newTransaction($ref, $marchs){
            foreach($marchs as $march){
                  $transaction  = new Detailtransactions;
                  $transaction->reference_transaction = $ref;
                  $transaction->reference_marchandise = Marchandise::getMarchRef($march["name"]) ;
                  $transaction->quantite = $march["quantite"] ;
                  $transaction->save();
            }
      }

      public static function setTimeZone(){
            date_default_timezone_set("Africa/Douala");
      }

      public static function genCode($code_type, $actual_indice){
            $racine = '';
            if ($code_type == "Marchandise") {
                  $racine = 'REF';
            }else if($code_type == "Mouvement") {
                  $racine = 'MOV';
            }else if($code_type == "Facture") {
                  $racine = 'FAC';
            }else if($code_type == "Vente") {
                  $racine = 'VNT';
            }else if($code_type == "Inventaire") {
                  $racine = 'INV';
            }else{
                  // caisse
            }
    
            $indice = '';
            if($actual_indice < 10){
               $indice = '000';
            }else if($actual_indice < 100){
               $indice = '00';
            }
            else if($actual_indice < 1000){
               $indice = '0';
            }else{
               $indice = '';
            }

    
            return  $racine . $indice . $actual_indice ;
      }
    
}
