<?php
namespace App\Services;

use App\Models\Inventaire;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use App\Models\Marchandise;
use Date;

class StockService{

      public function listInventory($stockdepot){
            return Inventaire::getInventory($stockdepot);
      }

      public function marchandiseDetails($ref){
         return Marchandise::where("reference",$ref)->get();
      }

      public function marchQuantity($marchandise){
         return Stockdepot::marchandiseQuantityStock($marchandise);
      }

      public function stockArticlesList($depot){
         return Stockdepot::getAllStockArticles($depot);
      }

      public function allArticlesMouvements($stockdepot){
         return Mouvementstock::getMouvementOperations($stockdepot);
      }

      public function situationDepot($depot){
         return  Stockdepot::getSituationDepot($depot);
      }

      public function newTransfer($designation, $quantité, $destination){
         $march = Marchandise::where("designation",$designation)->first();
         $this->newMouvementMarchandises($march->id, $quantité, "Transfert", $destination);
      }

      public function newSortie($designation, $quantité){
         $march = Marchandise::where("designation",$designation)->first();
         $this->newMouvementMarchandises($march->id, $quantité, "Sortie", null);
      }

      public function newEntree($designation, $quantité){
         $march = Marchandise::where("designation",$designation)->first();
         $this->newMouvementMarchandises($march->id, $quantité, "Entrée", null);
      }

      public function reajustMarch($designation, $quantité){
         $march = Marchandise::where("designation",$designation)->first();
         // nouvelle ligne inventaire
         $this->newLigneInventaire($designation, $quantité);
         // enregistre egalement comme une sortie
         $dif = ($this->marchQuantity($march->id) - (int)$quantité);
         $this->newMouvementMarchandises($march->id, $dif, "Sortie", null);
      }

      public function newLigneInventaire($designation, $quantité){
         $march = Marchandise::where("designation",$designation)->first();

         $ivt = new Inventaire;
         $ivt->stockdepot_id = 1;
         $ivt->marchandise_id = $march->id;
         $ivt->ancienne_quantite =  $this->marchQuantity($march->id);
         $ivt->quantite_reajuste = (int)$quantité;

         // pensez a faire la valeur absolue
         $ivt->difference = ($ivt->ancienne_quantite - $ivt->quantite_reajuste);
         $ivt->date_reajustement = date("Y-m-d");
         $ivt->save();
      }

      public function newMouvementMarchandises($id_march, $quantité, $type, $destination){
         $nbrows = Mouvementstock::all()->count();

         $mvt = new Mouvementstock;
         $mvt->marchandise_id = $id_march;
         // stock depot id figé faudra le rendre dyn apres gestion des users!!! 
         $mvt->stockdepot_id = 1;
         $mvt->reference_mouvement = 'Mouv00'. ($nbrows + 1) . '';
         $mvt->type_mouvement = $type;
         $mvt->quantite_mouvement = $quantité;
         $mvt->date_operation = date("Y-m-d");
         $mvt->destination = $destination == null ? null : $destination;
         $mvt->save();

         $stock = Stockdepot::where("marchandise_id",$id_march)->first();
         $stock->quantite_stock = $stock->quantite_stock - $quantité;
         $stock->date_derniere_modif_qté =  date("Y-m-d");
         $stock->save();
      }
}
