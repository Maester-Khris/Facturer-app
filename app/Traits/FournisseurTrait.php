<?php

namespace App\Traits;
use App\Models\Inventaire;
use App\Models\Fournisseur;
use App\Models\Facture;
use App\Models\Journalachat;
use App\Models\Comptecaisse;

trait FournisseurTrait {

      public static function getFournisseur($id_depot, $founi){
            $fourni = Fournisseur::where('depot_id',$id_depot)->where('nom_complet', $founi)->first();
            return $fourni;
      }
      
      public static function getFournisseurId($id_depot, $founi){
            $fourni = Fournisseur::where('depot_id',$id_depot)->where('nom_complet', $founi)->first();
            return $fourni->id;
      }

      public static function getFournisseurSolde($id_depot, $founi){
            $fourni = Fournisseur::where('depot_id',$id_depot)->where('nom_complet', $founi)->first();
            return $fourni->solde;
      }

      public static function getByDepot($id_depot){
            $fournisseurs = Fournisseur::where('depot_id',$id_depot)->orderBy('nom_complet','asc')->get();
            return $fournisseurs;
      }

}
