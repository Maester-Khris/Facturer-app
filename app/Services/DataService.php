<?php
namespace App\Services;


class DataService{

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
