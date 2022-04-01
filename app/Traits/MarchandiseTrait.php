<?php

namespace App\Traits;
use App\Models\Marchandise;

trait MarchandiseTrait {
      public static function getMarchId($designation){
            $march = Marchandise::where('designation',$designation)->first();
            return  $march->id;
      }

      public static function getMarchPrixDet($march_id){
            $march = Marchandise::where('id',$march_id)->first();
            return  $march->prix_vente_detail;
      }

      public static function getMarchPrixGro($march_id){
            $march = Marchandise::where('id',$march_id)->first();
            return  $march->prix_vente_gros;
      }

      public static function getMarch($designation){
            $march = Marchandise::where('designation',$designation)->first();
            return  $march;
      }

      public static function getMarchById($march_id){
            $march = Marchandise::where('id',$march_id)->first();
            return  $march;
      }
}