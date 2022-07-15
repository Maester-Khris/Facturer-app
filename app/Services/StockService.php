<?php
namespace App\Services;

use App\Models\Inventaire;
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
         $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Transfert", $destination, $today);
         // put the code to add each marchandise in the stock of the destination depot
      }
   }

   public function newMvtEntreeSortie($marchs, $type){
      $nbrows = Mouvementstock::distinct()->count('reference_mouvement');
      $ref_mouv = DataService::genCode("Mouvement", $nbrows + 1);
      $today = new DateTime();
      foreach($marchs as $march){
         if($type == "Entrée"){
            $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Entrée", null, $today);
         }else{
            $this->newMouvementMarchandises($ref_mouv, Marchandise::getMarchId($march["name"]), $march["quantite"], "Sortie", null, $today);
         }
      }
   }

   public function newMouvementMarchandises($mouv_ref, $id_march, $quantité, $type, $destination, $date){
      $mvt = new Mouvementstock;
      $mvt->marchandise_id = $id_march;
      $mvt->stockdepot_id = 1;
      $mvt->reference_mouvement =  $mouv_ref;
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


   /**
    * Retourne nb totale facture vente, nb totale ticket vente
    * marge et chiffre Affaire
   */
   /**
      * doit etre modifié pour prendre en compte les ventes deja reglé et les tickets cloturé
   */
   public function getStatGenerale($depotid){
      $nb_facture_ventes = Vente::all()->count();
      $nb_tickets = Ticket::all()->count();

      // calcul du chiffre Affaire :  somme montant net de tout les fac ventes reglé + pareil pour ticket cloturé
      $ventes = Vente::all();
      $tickets = Ticket::all();
      $somme_ventes = $ventes->reduce(function ($current, $vente) {
         return $current + $vente->montant_net ;
      },0);
      $somme_tickets = $tickets->reduce(function ($current, $ticket) {
         return $current + ($ticket->quantite * $ticket->prix_vente) ;
      },0);
      $chiffreAf = $somme_ventes + $somme_tickets;

      // calcul de la marge : chiffreAf - ( cmup * nbvente de chaque article )
      $ventes_marchandises = $this->getStatsVenteArticles(1);
      $valeur = $ventes_marchandises->reduce(function($current,$march){
         return $current + ($march->cmup * $march->nbvente);
      },0);
      $marge = $chiffreAf - $valeur;

     return [$nb_facture_ventes, $nb_tickets, $chiffreAf, $marge ];
   }

   /**
    * recupere la liste des facture de ventes (reglé avec leur marchandise) : FAA, designa
    * recupere la liste des tickets de ventes (pourra etre modifié plustard pour deja cloturé) : TC00, designa
    * on recupere la liste des articles du stock
    * pour chaque article on compte le nb de facture et ticket on additionne
   */
   /**
   * doit etre modifié pour prendre en compte les ventes deja reglé et les tickets cloturé
   */
   public function getStatsVenteArticles($depotid){
      

      // recupere touts les articles du depot 1 et leur infos
      // $articles = $this->stockArticlesList(1);
      $articles = Marchandise::select("reference","designation","cmup")->get();
      
      // recupere toutes les ventes du depot 1 et pour chaque ligne on a: ref_vente, ref_march, qte
      $ventes = Vente::join("clients","clients.id","=","ventes.client_id")
         ->join("detailtransactions","detailtransactions.reference_transaction","=","ventes.code_vente")
         ->select("ventes.code_vente","detailtransactions.reference_marchandise","detailtransactions.quantite")
         ->where("clients.depot_id",1)
         ->get();

      // recupere toutes les ticket du depot 1 et pour chaque ligne on a: ref_ticket, ref_march, qte
      $tickets = Ticket::join("comptoirs","comptoirs.id","=","tickets.comptoir_id")
         ->select("tickets.code_ticket","tickets.reference_marchandise","tickets.quantite")
         ->where("comptoirs.depot_id",1)
         ->get();

      /**
       * articles map use vente et ticket
       * nbvente=0
       * if ventes contains article.designation; nbvente = count(indexof(articledesignation))dans vente
       * if ticket meme chose nbventes = nbventes + mem chose
       * return [article designation; reference, nbvente]
       */
      $results = $articles->map(function($article) use ($ventes,$tickets){
         $res = new \stdClass();
         $res->reference = $article->reference;
         $res->designation = $article->designation;
         $res->cmup = $article->cmup;
         $res->nbvente = 0;
         $nb1 = $ventes->filter(function ($value, $key) use ($article) {
            return $value->reference_marchandise == $article->reference;
         })->count();
         $nb2 = $tickets->filter(function ($value, $key) use ($article) {
            return $value->reference_marchandise == $article->reference;
         })->count();
         $res->nbvente += ($nb1 + $nb2);
         return $res;
      });
      return $results;  
      
   }


   // public function newTransfer($designation, $quantité, $destination){
   //    $march = Marchandise::where("designation",$designation)->first();
   //    $today = new DateTime();
   //    $this->newMouvementMarchandises($march->id, $quantité, "Transfert", $destination, $today);
   // }

   // public function newSortie($designation, $quantité){
   //    $march = Marchandise::where("designation",$designation)->first();
   //    $today = new DateTime();
   //    $this->newMouvementMarchandises($march->id, $quantité, "Sortie", null, $today);
   // }

   // public function reajustMarch($designation, $quantité, $date){
   //    $march = Marchandise::where("designation",$designation)->first();

   //    // enregistre egalement comme une sortie
   //    $dif = abs($this->marchQuantity($march->id) - (int)$quantité);
   //    $this->newMouvementMarchandises($march->id, $dif, "Sortie", null, $date);

   //    // nouvelle ligne inventaire
   //    $this->newLigneInventaire($designation, $quantité, $date, false);
   // }
}
