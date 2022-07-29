<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Marchandise;
use App\Models\Ticket;
use App\Models\Client;
use App\Models\Stockdepot;
use App\Models\Detailtransactions;
use DateTime;
use Date;

class VentecomptoirService{

      public static function findWaitingTicket($code){
            $ticket = Ticket::where("code_ticket",$code)->where("statut","non termine")->first();
            return $ticket;
      }

      public function newTicket($code, $client, $statut, $total, $employee_id, $today){
            $comptoir = DataService::getComptoirPersonnel($employee_id);
            $client = Client::find(DataService::getClient($client, $comptoir->personnel->depot->id));
            $ticket = Ticket::create([
                  'code_ticket' => $code, 
                  'comptoir_id' => $comptoir->id, 
                  'client_id' => $client->id, 
                  'total' => $total, 
                  'date_operation' => $today, 
                  'statut' => $statut
            ]);
            return $ticket;
      }

      public function updateWaitingTicket($ticket, $total){
            $today = new DateTime();
            $ticket->total = $total;
            $ticket->date_operation = $today;
            $ticket->save();
      }
      public function validateWaitingTicket($ticket, $total){
            $today = new DateTime();
            $ticket->total = $total;
            $ticket->statut = "en cours";
            $ticket->date_operation = $today;
            $ticket->save();
      }


      /** Factures vente de fin de journee apres la cloture de la caisse
       * remise=0, total =0, net=sum du total de chaque ticket du client
       * UNIQUEMENT LES TICKET EN COURS ???
      */
      /**
         * suppose que une caisse a ++ comptoir
         * recupere la liste des comptoir
         * recupere la liste des tickets avec idcomptoir in comptoir
         * cree un tableau qui contient la liste des clientid
         * pour chaque idclient on filtre les ticket et cree une facture vente 
         * on cree aussi detail transaction pour cette facture
        */
      public static function closeCaisseFactureVentes($caisse){
            $comptoirids = $caisse->comptoirs->map(function($item){
                  return $item->id;
            });
            $tickets = Ticket::whereIn('comptoir_id', $comptoirids)->get();
            if(!$tickets->isEmpty()){
                  $clientids = $tickets->map(function($item){
                        return $item->client_id;
                  })->unique('client_id')->values()->all();

                  foreach($clientids as $client){
                        $today = new DateTime();
                        $ticketsclient =  $tickets->filter(function($item) use ($client){
                              return $item->client_id == $client;
                        });
                        $comptoir = $caisse->comptoirs->first();
                        $nbrows = VenteService::allDepotVenteCount($comptoir->depot->id);
                        $code =  DataService::genCode("Vente", $nbrows + 1);
                        $montant = [0, 0, $ticketsclient->sum('total')];
                        $vente = VenteService::newVente($client, $code, $montant, $today);
                        // devra etre modifé plustard pour integrer les operations compta
                        $vente->statut = true;
                        $vente->save();
                        $ticketsclient->each(function ($item, $key) use($vente, $today) {
                              $transaction = new Detailtransactions;
                              $transaction->reference_transaction = $vente->code_vente;
                              $transaction->reference_marchandise = $item->code_ticket;
                              $transaction->quantite = 0 ;
                              $transaction->prix = 0 ;
                              $transaction->save();  

                              $details = Detailtransactions::where('reference_transaction',$item->code_ticket)->get();
                              if($details){
                                    $details->each(function ($detail, $key) use($vente, $today) {
                                          $marchid = Marchandise::getMarchIdByRef($detail->reference_marchandise);
                                          $marchqte = $detail->quantite;
                                          StockService::newMouvementMarchandises($vente->code_vente, $marchid, $marchqte, "Sortie", null, $today, false);
                                    });
                              }
                              $item->statut = "archive";
                              $item->save();
                        });
                  }
            }
      }

      public static function requestTicketCaisse($caisse, $statut, $periode_min, $periode_max){
            if($statut == "archive"){
                  $data = Ticket::getTicketArchiveByComptoir($caisse, $periode_min, $periode_max);
            }else if($statut == "en_cours"){
                  $data = Ticket::getTicketEnCoursByComptoir($caisse, $periode_min, $periode_max);
            }
            return $data;
      }

      

      /**
       *  Details about waiting tickets
      */ 
      public static function getTicketenAttente(){
            $data = Ticket::where('statut','non termine')
            ->join('detailtransactions',"tickets.code_ticket","=","detailtransactions.reference_transaction")
            ->join('marchandises',"detailtransactions.reference_marchandise","=","marchandises.reference")
            ->select(
                  'tickets.code_ticket','tickets.total','tickets.date_operation',"detailtransactions.reference_marchandise",
                  "marchandises.designation","detailtransactions.quantite","detailtransactions.prix"
            )->orderBy('tickets.date_operation','asc')
            ->get();
            return $data;
      }
}