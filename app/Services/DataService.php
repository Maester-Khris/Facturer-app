<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Marchandise;
use App\Models\Personnel;
use App\Models\Ticket;
use App\Models\Facture;
use App\Models\Vente;
use App\Models\Client;
use App\Models\Caisse;
use App\Models\Stockdepot;
use App\Models\Detailtransactions;
use \stdClass;

class DataService{

      public static function checkCaisseOpened($caisseid){
            $caisse = Caisse::where('id',$caisseid)->where('statut','ouvert')->get();
            // dd($caisse);
            if($caisse->isEmpty()){
                  return false;
            }else{
                  return true;
            }
            
      }
      public static function getComptoirPersonnel($person_id){
            $employe = Personnel::find($person_id);
            return $employe->comptoir;
      }
      public static function getClient($nom, $depotid){
            $clientid = Client::getClientId($nom, $depotid);
            return $clientid;
      }

      public static function Marchandisesuggestion($march_name){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->limit(3)
                ->get();
            return $marchs;
      }
      public static function MarchandisescompletionVente($march_name){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->limit(3)
                ->get();
            $additional = $marchs->map(function($march) {
                  return DataService::Marchandisestockinfo($march->designation);
            });
            return [$marchs, $additional];
      }
      public static function Clientsuggestion($client_name){
            $client = Client::where('nom_complet','LIKE','%'.$client_name.'%')
                ->limit(3)
                ->get();
            return $client;
      }
      public static function getClientTarification($client){
            $clt = Client::where('nom_complet','LIKE','%'.$client_name.'%')
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

      // doit etre modifié pour prendre en compte le depot
      public static function detailsTransaction($type, $code, $depotid){
            if($type == "Ticket"){
                  $ticket = Ticket::getTicketByDepot($code, $depotid);
                  $details = Detailtransactions::where('reference_transaction',$ticket->code_ticket)->get();
            }elseif($type == "Facture"){
                  $facture = Facture::getFactureByDepot($code, $depotid);
                  $details = Detailtransactions::where('reference_transaction',$facture->code_facture)->get();
            }elseif($type == "Vente"){
                  $vente = Vente::getVenteByDepot($code, $depotid);
                  $details = Detailtransactions::where('reference_transaction',$vente->code_vente)->get();
            }
            $details->map(function ($item) {
                  $march = Marchandise::getMarchByRef($item->reference_marchandise);
                  $item['designation'] = $march->designation;
                  return $item;
            });
            return $details;
      }

      public static function newTransaction($ref, $marchs, $today){
            foreach($marchs as $march){
                  $produit = Marchandise::getMarch($march["name"]);
                  $transaction = new Detailtransactions;
                  $transaction->reference_transaction = $ref;
                  $transaction->reference_marchandise = $produit->reference;
                  $transaction->quantite = $march["quantite"] ;
                  $transaction->prix = $march["prix"] ;
                  $transaction->save();
                  StockService::updatStockMarchandise($produit->id, $march["quantite"], "Sortie", $today);
            }
      }

      public function updateTransactionAddLines($ref, $marchs, $today){
            foreach($marchs as $march){
                  $transaction = Detailtransactions::where("reference_transaction",$ref)
                  ->where("reference_marchandise", Marchandise::getMarchRef($march["name"]))->first();
                  if($transaction == null){
                        DataService::newTransaction($ref, [$march], $today);
                  }
            }
      }

     /**
    * Retourne nb totale facture vente : Client et Vente resume de ticket
    * calcul du chiffre Affaire :  somme montant net de tout les fac ventes reglé + pareil pour ticket cloturé 
    * calcul de la marge : chiffreAf - ( cmup * nbvente de chaque article )
   */
   public function getStatGenerale($depotid, $periode_min, $periode_max){
      $ventes = Vente::paidVenteByDepot($depotid, $periode_min, $periode_max);
      $tickets = Ticket::getAllTicketArchivesByDepot($depotid, $periode_min, $periode_max);
      $chiffreAf = $ventes->reduce(function ($current, $vente) {
         return $current + $vente->montant_net ;
      },0);
      $ventes_marchandises = DataService::getStatsVenteArticles($depotid, $periode_min, $periode_max);
      $valeur = $ventes_marchandises->reduce(function($current,$march){
         return $current + ($march->cmup * $march->nbvente);
      },0);
      $marge = $chiffreAf - $valeur;

     return [$ventes->count(), $tickets->count(), $chiffreAf, $marge ];
   }

   /**
    * recupere la liste des facture de ventes (reglé avec leur marchandise) : FAA, designa
    * on recupere la liste des articles du stock
    * pour chaque article on compte le nb de facture 
    * doit etre modifié pour prendre en compte les ventes deja reglé 
   */
   public function getStatsVenteArticles($depotid, $periode_min, $periode_max){
      $articles = Marchandise::select("reference","designation","cmup","prix_achat")->get();
      $vente_def = collect();
      
      $ventes = Vente::where('statut',true)
         ->whereBetween('date_operation', [$periode_min, Carbon::parse($periode_max)->endOfDay()])
         ->join("clients","clients.id","=","ventes.client_id")
         ->join("detailtransactions","detailtransactions.reference_transaction","=","ventes.code_vente")
         ->select("ventes.code_vente","detailtransactions.reference_marchandise","detailtransactions.quantite")
         ->where("clients.depot_id",$depotid)
         ->get();

      $vente_comptoir = $ventes
            ->filter(function($item){
                  $tkt = substr($item->reference_marchandise, 0, 3);
                  if( $tkt == "TKT") 
                        return $item; 
            })->map(function($item) use ($vente_def){
                  $details = Detailtransactions::where('reference_transaction',$item->reference_marchandise)->get();
                  $details->each(function($elt) use ($item, $vente_def) { 
                        $vente_def->push([
                              "code_vente" => $item->code_vente,
                              "reference_marchandise" => $elt->reference_marchandise,
                              "quantite" => $elt->quantite
                        ]);
                  });
            });;
      $ventes->each(function($item) use ($vente_def){
            $tkt = substr($item->reference_marchandise, 0, 3);
            if( $tkt != "TKT"){
                  $vente_def->push([
                        "code_vente" => $item->code_vente,
                        "reference_marchandise" => $item->reference_marchandise,
                        "quantite" => $item->quantite
                  ]);
            } 
      });

      $results = $articles->map(function($article) use ($vente_def){
         $res = new \stdClass();
         $res->reference = $article->reference;
         $res->prix = $article->prix_achat;
         $res->designation = $article->designation;
         $res->cmup = $article->cmup;
         $res->nbvente = 0;
         $nb1 = $vente_def->filter(function ($value, $key) use ($article) {
            return $value['reference_marchandise'] == $article->reference;
         })->count();
        
         $res->nbvente += $nb1 ;
         return $res;
      });
      return $results;
   }

      public static function genCode($code_type, $actual_indice){
            $racine = '';
            if ($code_type == "Marchandise") {
                  $racine = 'REF';
            }else if($code_type == "Caisse") {
                  $racine = 'CAI';
            }else if($code_type == "Facture") {
                  $racine = 'FA';
            }else if($code_type == "Vente") {
                  $racine = 'FV';
            }else if($code_type == "Inventaire") {
                  $racine = 'INV';
            }else if($code_type == "Ticket") {
                  $racine = 'TKT';
            }else if($code_type == "Personnel") {
                  $racine = 'MAT';
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
