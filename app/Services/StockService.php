<?php
namespace App\Services;

use App\Models\Inventaire;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use App\Models\Marchandise;
use DateTime;


class StockService{

   public function marchandiseDetails($ref){
      return Marchandise::where("reference",$ref)->get();
   }
   public function allArticlesMouvements($stockdepot){
      return Mouvementstock::getMouvementOperations($stockdepot);
   }
   public function listInventory($stockdepot){
      return Inventaire::getInventory($stockdepot);
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
   public function stockArticlesList($depot){
      return Stockdepot::getAllStockArticles($depot);
   }
   public function situationDepot($depot){
      return  Stockdepot::getSituationDepot($depot);
   }


   public function newTransfer($designation, $quantité, $destination){
      $march = Marchandise::where("designation",$designation)->first();
      $today = new DateTime();
      $this->newMouvementMarchandises($march->id, $quantité, "Transfert", $destination, $today);
   }

   public function newSortie($designation, $quantité){
      $march = Marchandise::where("designation",$designation)->first();
      $today = new DateTime();
      $this->newMouvementMarchandises($march->id, $quantité, "Sortie", null, $today);
   }

   public function newEntree($designation, $quantité){
      $march = Marchandise::where("designation",$designation)->first();
      $today = new DateTime();
      $this->newMouvementMarchandises($march->id, $quantité, "Entrée", null, $today);
   }

   public function reajustMarch($designation, $quantité, $date){
      $march = Marchandise::where("designation",$designation)->first();

      // enregistre egalement comme une sortie
      $dif = abs($this->marchQuantity($march->id) - (int)$quantité);
      $this->newMouvementMarchandises($march->id, $dif, "Sortie", null, $date);

      // nouvelle ligne inventaire
      $this->newLigneInventaire($designation, $quantité, $date, false);
   }

   public function newLigneInventaire($designation, $quantité, $date, $flag){
      $march = Marchandise::where("designation",$designation)->first();

      $ivt = new Inventaire;
      $ivt->stockdepot_id = 1;
      $ivt->marchandise_id = $march->id;
      $ivt->ancienne_quantite =  $this->marchQuantity($march->id);
      $ivt->quantite_reajuste = (int)$quantité;

      // pensez a faire la valeur absolue
      $ivt->difference = abs($ivt->ancienne_quantite - $ivt->quantite_reajuste);
      $ivt->date_reajustement = $date;
      $ivt->save();

      if($flag == false){
         // modifie le stock
         $stock = Stockdepot::where("marchandise_id",$march->id)->first();
         $stock->quantite_stock = (int)$quantité;
         $stock->date_derniere_modif_qté = $date;
         $stock->save();
      }
   }

   public function newMouvementMarchandises($id_march, $quantité, $type, $destination, $date){
      $nbrows = Mouvementstock::all()->count();

      $mvt = new Mouvementstock;
      $mvt->marchandise_id = $id_march;
      // stock depot id figé faudra le rendre dyn apres gestion des users!!! 
      $mvt->stockdepot_id = 1;
      // $mvt->reference_mouvement =  'Mouv00'. ($nbrows + 1) . '';
      $mvt->reference_mouvement =  DataService::genCode("Mouvement", $nbrows + 1);
      $mvt->type_mouvement = $type;
      $mvt->quantite_mouvement = $quantité;
      $mvt->date_operation = $date; 
      $mvt->destination = $destination == null ? null : $destination;
      $mvt->save();
     
      $stock = Stockdepot::where("marchandise_id",$id_march)->first();
      if($type == "Sortie" || $type == "Transfert"){
         $stock->quantite_stock = abs($stock->quantite_stock - $quantité);
      }else{
         $stock->quantite_stock = $stock->quantite_stock + $quantité;
      }
      
      $stock->date_derniere_modif_qté = $date;
      $stock->save();
   }
}
