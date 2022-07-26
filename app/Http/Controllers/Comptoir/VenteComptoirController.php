<?php

namespace App\Http\Controllers\Comptoir;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Client;
use App\Services\DataService;
use App\Services\VentecomptoirService; 
use Illuminate\Http\Request;
use DateTime;

class VenteComptoirController extends Controller
{
    public function index(Request $request){
        // erreur si le comptoir de ce bonhomme n'existe pas
        $employee_id = $request->session()->get('personnel_id');
        $comptoir = DataService::getComptoirPersonnel($employee_id);
        $client = Client::find(DataService::getClient("Clt ".$comptoir->libelle, $comptoir->personnel->depot->id)) ;
        $client_comptoir = $client->nom_complet;
        $nbrows = Ticket::count();
        $nouveau_code = DataService::genCode("Ticket", $nbrows + 1);
        $statut_caisse = DataService::checkCaisseOpened($comptoir->caisse->id);
        return view('comptoir.ventesComptoir')->with(compact('client_comptoir'))->with(compact('nouveau_code'))->with(compact('statut_caisse'));
    }

    /**
     * si nouveau ticket: enregistre le ticket et la transaction
     * si ticket existant: 
     * recherche le ticket et on modifie le total et le statut
     * recherche la transaction par (reference trans et reference marchandise): ajouter ceux qui n'existe pas encore
    */
    public function saveTicketEnCours(Request $request){
        if(isset($request->ticket['marchandises'])) {
            $last_ticket = VentecomptoirService::findWaitingTicket($request->ticket['codeticket']);
            $today = new DateTime();
            if(is_null($last_ticket)){
                $employee_id = $request->session()->get('personnel_id');
                $ticket = VentecomptoirService::newTicket($request->ticket['codeticket'], $request->ticket['client'], 'en cours', $request->ticket['total'], $employee_id, $today);
                DataService::newTransaction($ticket->code_ticket, $request->ticket['marchandises'], $today);
            }else{
                VentecomptoirService::validateWaitingTicket($last_ticket, $request->ticket['total']);
                DataService::updateTransactionAddLines($last_ticket->code_ticket, $request->ticket['marchandises'], $today);
            }
            return response()->json(["res" => "successful"]);
        }else{
            return response()->json(["res" => "aucune marchandises"]);
        }
    }

    public function saveTicketEnAttente(Request $request){
        if(isset($request->ticket['marchandises'])) {
            $last_ticket = VentecomptoirService::findWaitingTicket($request->ticket['codeticket']);
            $today = new DateTime();
            if(is_null($last_ticket)){
                $employee_id = $request->session()->get('personnel_id');
                $ticket = VentecomptoirService::newTicket($request->ticket['codeticket'], $request->ticket['client'], 'non termine', $request->ticket['total'], $employee_id, $today);
                DataService::newTransaction($ticket->code_ticket, $request->ticket['marchandises'], $today);
            }else{
                VentecomptoirService::updateWaitingTicket($last_ticket, $request->ticket['total']);
                DataService::updateTransactionAddLines($last_ticket->code_ticket, $request->ticket['marchandises'], $today);
            }
            return response()->json(["res" => "successful"]);
        }else{
            return response()->json(["res" => "aucune marchandises"]);
        }
    }

    public function rappelTicketEnAttente(){
        $data = VentecomptoirService::getTicketenAttente();
        return response()->json($data);
    }

    public function newCodeTicket(){
        $nbrows = Ticket::count();
        $nouveau_code = DataService::genCode("Ticket", $nbrows + 1);
        return response()->json(["code" => $nouveau_code]);
    }
}
