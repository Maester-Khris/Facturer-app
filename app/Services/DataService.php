<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Marchandise;
use App\Models\Compte;
use App\Models\Mouvementstock;
use App\Models\Personnel;
use App\Models\Ticket;
use App\Models\Depot;
use App\Models\Facture;
use App\Models\User;
use App\Models\Vente; 
use App\Models\Client;
use App\Models\Caisse;
use App\Models\Comptoir;
use App\Models\Stockdepot;
use App\Models\Fournisseur;
use App\Models\Detailtransactions;
use \stdClass;
use Illuminate\Database\Eloquent\Collection;

class DataService{

      /**
       * ====================== Verification methods =======================
      */
      public static function checkCaisseOpened($caisseid){
            $caisse = Caisse::where('id',$caisseid)->where('statut','ouvert')->get();
            return $caisse->isEmpty() ? false : true;
      }
      public static function checkEmployeeCanReturnMarch($employeid){
            $employe = Personnel::find($employeid);
            $authorised_employee_user = User::where('id',  $employe->user_id)
                  ->whereHas('roles', function($query) {
                        $query->where('name','=', 'chef_equipe')
                        ->orWhere('name','=', 'comptable');
                  })
                  ->first();
            return is_null($authorised_employee_user) ? false : true;
      }
      public static function checkVendeursCaisseLoggedout($caisse){
            $comptoirs = $caisse->comptoirs;
            $employees = collect();
            foreach($comptoirs as $comptoir){
                  $personels = Personnel::where('depot_id',$comptoir->depot->id)
                  ->wherein('poste',['vendeur','chef_boutique'])
                  ->join('users','users.name','=','personnels.nom_complet')
                  ->where('users.statut',true)
                  ->select('personnels.*')
                  ->get();
                  if($personels){ 
                        if($employees->isEmpty()){
                              $employees->push($personels);
                        }else{
                              $employees->merge($personels);
                        }
                  }
            }
            $employees = $employees->first();
            $comptoirids = $caisse->comptoirs->map(function($item){ return $item->id; });
            $employecomptoirloggedout = $employees->filter(function($item) use ($comptoirids){
                  if($comptoirids->contains($item->comptoir->id)){
                        return $item;
                  }
            });
            return $employecomptoirloggedout->count() == 0 ? true : false;
      }

      /**
       * ====================== Getters methods =======================
      */
      public static function getComptoirDepotId($employeid){
            $comptoir = DataService::getComptoirPersonnel($employeid);
            return $comptoir->personnel->depot->id;
      }
      public static function getComptoirPersonnel($person_id){
            $employe = Personnel::find($person_id);
            return $employe->comptoir;
      }
      public static function getFirstCaisseDepot($depotid){
            $depot = Depot::find($depotid);
            $comptoir = Comptoir::getFirstComptoirDepot($depotid);
            return $comptoir->caisse;
      }
      public static function getClient($nom, $depotid){
            $clientid = Client::getClientId($nom, $depotid);
            return $clientid;
      }
      public static function getClientTarification($client){
            $clt = Client::where('nom_complet','LIKE','%'.$client_name.'%')
            ->limit(3)
            ->get();
        return $marchs;
      }
      public static function countAllMarchs(){
            $marchs = Marchandise::all();
            return $marchs->count();
      }
      public static function countMvtPerDepot($iddepot){
            $mvts = Mouvementstock::getMouvementOperations($iddepot);
            return $mvts->count();
      }
      public static function countClientPerDepot($iddepot){
            $clients = Client::allDepotClientWithDefaults($iddepot); 
            return $clients->count();
      }
      public static function countFournisseurPerDepot($iddepot){
            $fournis = Fournisseur::getByDepot($iddepot);   
            return $fournis->count();
      }
      public static function countCaissePerDepot($iddepot){
            $caisses = Caisse::where('depot_id',$iddepot)->get();
            return $caisses->count();
      }
      public static function countAutreCompte($nom,$type){
            $comptes = Compte::where('intitule','LIKE','%'.$nom.'%')->where('type',$type)->get();
            return $comptes->count();
      }
      public static function countQteNegative($marchandises){
            $qteegatives = collect($marchandises)->filter(function($item){
                  return $item['quantite'] < 0;
              })->count();
            return $qteegatives;
      }
      public static function Marchandisestockinfo($march_des, $id_depot){
            // dd($march_ref);
            $march = Marchandise::getMarchByDes($march_des);
            // dd('we comming');
            // dd($march);
            $march_stock_info = Stockdepot::marchandiseStockInfo($march->id, $id_depot);
            return  [$march_stock_info->quantite_stock,  $march->reference];
      }


      /**
       * ==================== Autocomplete methods =======================
      */
      public static function Marchandisesuggestion($march_name){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->limit(3)
                ->get();
            return $marchs;
      }
      public static function MarchandiseDepotsuggestion($march_name, $depotid){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->join("stockdepots","stockdepots.marchandise_id","=","marchandises.id")
                ->where("stockdepots.depot_id",$depotid)
                ->limit(3)
                ->select("marchandises.*","stockdepots.quantite_stock")
                ->get();
            return $marchs;
      }
      public static function MarchandisescompletionVente($march_name, $id_depot){
            $marchs = Marchandise::where('designation','LIKE','%'.$march_name.'%')
                ->limit(3)
                ->get();
            // dd($marchs);
            $additional = $marchs->map(function($march) use($id_depot) {
                  // dd($id_depot);
                  return DataService::Marchandisestockinfo($march->designation, $id_depot);
            });
            // dd($additional);
            return [$marchs, $additional];
      }
      public static function Clientsuggestion($client_name, $depotid){
            $clients = Client::getClientByDepot($client_name, $depotid);
            return $clients;
      }
      public static function Fournisseursuggestion($fourni_name, $depotid){
            $fournis = Fournisseur::where('depot_id',$depotid)
            ->where('nom_complet','like','%'.$fourni_name.'%')
            ->orderBy('nom_complet','asc')
            ->limit(3)
            ->get();
            return $fournis;
      }

    
      /**
       * ====================== Transactions methods =======================
      */
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

     
   // 1- Retourne nb totale facture vente : Client et Vente resume de ticket
   // 2- calcul du chiffre Affaire :  somme montant net de tout les fac ventes reglé + pareil pour ticket cloturé 
   // 3- calcul de la marge : chiffreAf - ( cmup * nbvente de chaque article ) 
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

   // 1- recupere la liste des facture de ventes (reglé avec leur marchandise + la liste article du stock
   // 2- pour chaque article on compte le nb de facture 
   // 3- doit etre modifié pour prendre en compte les ventes deja reglé 
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
      if ($code_type == "CompteF") {
            $racine = '401';
      }else if($code_type == "CompteCLT") {
            $racine = '411';
      }else if($code_type == "CompteCAI") {
            $racine = '571';
      }else if($code_type == "CompteMarchA") {
            $racine = '601';
      }else if($code_type == "CompteMarchV") {
            $racine = '701';
      }else if($code_type == "CompteCharge") {
            $racine = '500';
      }else if($code_type == "CompteGene") {
            $racine = '600';
      }else if($code_type == "CompteProd") {
            $racine = '700';
      }else if($code_type == "Marchandise") {
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
      }else if($code_type == "MvtE") {
            $racine = 'ME';
      }else if($code_type == "MvtS") {
            $racine = 'MS';
      }else if($code_type == "MvtT"){
            $racine = 'TR';
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
