<?php
namespace App\Services;

use App\Models\Inventaire;
use App\Models\Depot;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use App\Models\Marchandise;
use App\Models\Vente;
use App\Models\Ticket;
use DateTime;
use \stdClass;


class StockService{

   public function marchandiseDetails($ref){
      return Marchandise::where("reference",$ref)->get();
   }
   public function allMouvements($stockdepot){
      return Mouvementstock::getMouvementOperations($stockdepot);
   }
   public function detailsMouvement($stockdepot, $code_mouvement){
      return Mouvementstock::getMarchandiseMvt($stockdepot, $code_mouvement);
   }
   public function listInventory($stockdepot){
      return Inventaire::getInventory($stockdepot);
   }
   public function detailsInventaire($stockdepot, $code_inventaire){
      return Inventaire::getMarchandiseIvt($stockdepot, $code_inventaire);
   }
   public function marchQuantity($marchandise){
      return Stockdepot::marchandiseQuantityStock($marchandise);
   }
   public function stockMarchDisponibility($designation, $quantite){
      return Stockdepot::checkStockMarchDispoByDesign($designation, $quantite);
   }
   public function stockMarchFull($designation){
      return Stockdepot::checkStockMarchFullByDesign($designation);
   }
   // retourne tout les articles du stock et leur info
   public function stockArticlesList($depot){
      return Stockdepot::getAllStockArticles($depot);
   }
   public function situationDepot($depot){
      return  Stockdepot::getSituationDepot($depot);
   }

   public static function addMarchandiseInAllStock($marchid){
      $depots = Depot::all();
      $depots->each(function($item) use ($marchid){
         $stock = new Stockdepot;
         $stock->depot_id = $item->id;
         $stock->marchandise_id = $marchid;
         $stock->quantite_stock = 0;
         $stock->save();
      });
   }

   /**
    *   reajouter un controler pour les qte negative pour gerer les factures d'avoir
    *   comment gerer le fait qu'on veuille enlever plus qu'il yen a dans le stock ??
   */
   public static function updatStockMarchandise($id_march, $qtemodifie, $type, $today){
      $stock = Stockdepot::where("marchandise_id",$id_march)->first();
      if($type == "Sortie" || $type == "Transfert"){
         if($qtemodifie > 0){
            $stock->quantite_stock = ($stock->quantite_stock >= $qtemodifie) ? $stock->quantite_stock - $qtemodifie : 0;
         }else{
            // utilisé pour modeliser les facture d'avoir
            $stock->quantite_stock = $stock->quantite_stock + abs($qtemodifie);
         }
      }else{
         $stock->quantite_stock = $stock->quantite_stock + $qtemodifie;
      }
      
      $stock->date_derniere_modif_qté = $today;
      $stock->save();
   }

   public function updateCmupDernierPrixAchat($marchs){
      foreach($marchs as $march){
         $marchandise = Marchandise::getMarch($march['name']);
         $ancien_valeur_stock = $this->marchQuantity($marchandise->id) *  $marchandise->dernier_prix_achat;
         $cout_acquisition = $march['quantite'] * $march['prix_achat'];
         $new_totalstock = $this->marchQuantity($marchandise->id) +  $march['quantite'];
         $new_cmup = ($ancien_valeur_stock + $cout_acquisition ) / $new_totalstock;

         $marchandise->cmup = $new_cmup;
         $marchandise->dernier_prix_achat = $march['prix_achat'];
         $marchandise->save();
      }
   }

   public function newMvtTransf($marchs, $destination){
      $nbrows = Mouvementstock::distinct()->count('reference_mouvement');
      $ref_mouv = DataService::genCode("Mouvement", $nbrows + 1);
      $today = new DateTime();
      foreach($marchs as $march){
         $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Transfert", $destination, $today, true);
         // put the code to add each marchandise in the stock of the destination depot
      }
   }

   public function newMvtEntreeSortie($marchs, $type){
      $nbrows = Mouvementstock::distinct()->count('reference_mouvement');
      $ref_mouv = DataService::genCode("Mouvement", $nbrows + 1);
      $today = new DateTime();
      foreach($marchs as $march){
         if($type == "Entrée"){
            $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Entrée", null, $today, true);
         }else{
            $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Sortie", null, $today, true);
         }
      }
   }

   public function newMouvementMarchandises($mouv_ref, $id_march, $quantité, $type, $destination, $date, $allow_stock_modif){
      $mvt = new Mouvementstock;
      $mvt->marchandise_id = $id_march;
      $mvt->stockdepot_id = 1;
      $mvt->reference_mouvement =  $mouv_ref;
      $mvt->type_mouvement = $type;
      $mvt->quantite_mouvement = $quantité;
      $mvt->date_operation = $date; 
      $mvt->destination = $destination == null ? null : $destination;
      $mvt->save();
      if($allow_stock_modif == true){
         StockService::updatStockMarchandise($id_march, $quantité, $type, $date);
      }
   }

   public function newSaisieInventaire($marchs){
      // $march = Marchandise::where("designation",$designation)->first();
      $today = new DateTime();
      $nbrows = Inventaire::distinct()->count('reference_inventaire');
      $ref_inv = DataService::genCode("Inventaire", $nbrows + 1);

      foreach($marchs as $march){
         $march_id = Marchandise::getMarchId($march["name"]);
         $ivt = new Inventaire;
         $ivt->stockdepot_id = 1;
         $ivt->marchandise_id = $march_id;
         $ivt->reference_inventaire = $ref_inv;
         $ivt->ancienne_quantite =  $this->marchQuantity($march_id);
         $ivt->quantite_reajuste = (int)$march["newquantite"];

         // pensez a faire la valeur absolue
         $ivt->difference = abs($ivt->ancienne_quantite - $ivt->quantite_reajuste);
         $ivt->date_reajustement = $today;
         $ivt->save();
      
         // modifie le stock
         $stock = Stockdepot::where("marchandise_id",$march_id)->first();
         $stock->quantite_stock = (int)$march["newquantite"];
         $stock->date_derniere_modif_qté = $today;
         $stock->save();
      }
   }

   public function NewEtatInventaire($depotid){
      $etat = Stockdepot::where("depot_id",$depotid)
         ->join("marchandises","stockdepots.marchandise_id","=","marchandises.id")
         ->select("marchandises.reference","marchandises.designation","stockdepots.quantite_stock")
         ->get();

      return $etat;
   }

   public function NewEtatInventaireWithValorisation($depotid, $type_valorisation){
      /**
       * recupere la liste des marchandise d'un stock 
       * join avec marchandise pour recuperer: reference, designation, variable (cmup, pa, der_pa)
      */
      $valorisation_column = "marchandises.";
      if($type_valorisation == "prix_achat"){
         $valorisation_column .= "prix_achat";
      }else if($type_valorisation == "dernier_prix_achat"){
         $valorisation_column .= "dernier_prix_achat";
      }else if($type_valorisation == "cmup"){
         $valorisation_column .= "cmup";
      }
      
      $etat = Stockdepot::where("depot_id",$depotid)
         ->join("marchandises","stockdepots.marchandise_id","=","marchandises.id")
         ->select("marchandises.reference","marchandises.designation",$valorisation_column,"stockdepots.quantite_stock")
         ->get();

      return $etat;
   }

}