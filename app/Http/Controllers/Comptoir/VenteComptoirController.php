<?php

namespace App\Http\Controllers\Comptoir;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

use App\Models\Caisse;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\Stockdepot;
use App\Models\Marchandise;
use App\Services\DataService; 
use App\Services\StockService;
use App\Services\PrintService; 
use App\Services\VentecomptoirService; 
use Illuminate\Support\Facades\Auth;

class VenteComptoirController extends Controller
{
    /**
     * CONNECTION METHODS
     * GERER ERRUR FALASE CONNECTION
     */
    public function index(Request $request){
        if(Auth::user()->hasAnyRole(["vendeur","chef_equipe"])){
            // erreur si le comptoir de ce bonhomme n'existe pas
            $employee_id = $request->session()->get('personnel_id');
            $comptoir = DataService::getComptoirPersonnel($employee_id);
            $client = Client::find(DataService::getClient("Clt ".$comptoir->libelle, $comptoir->personnel->depot->id)) ;
            $client_comptoir = $client->nom_complet;
            $nbrows = Ticket::count();
            $nouveau_code = DataService::genCode("Ticket", $nbrows + 1);
            $statut_caisse = DataService::checkCaisseOpened($comptoir->caisse->id);
            return view('comptoir.ventesComptoir')->with(compact('client_comptoir'))->with(compact('nouveau_code'))->with(compact('statut_caisse'));
        }else{
            return view('comptoir.ventesComptoirRedirect');
        }
    }
    /**
     * VIEWW RENDERING METHODS
    */
    public function printTicket(Request $request, $codeTicket){
        $employee_id = $request->session()->get('personnel_id');
        $id_depot = DataService::getComptoirDepotId($employee_id);
        $details = DataService::detailsTransaction('Ticket',$codeTicket,$id_depot);
        return view('comptoir.ticketComptoir')->with(compact('details')); 
    }
    
   
    /**
     * ====================== BUSINESS METHODS ================================
     * si nouveau ticket: enregistre le ticket et la transaction
     * si ticket existant: 
     * recherche le ticket et on modifie le total et le statut
     * recherche la transaction par (reference trans et reference marchandise): ajouter ceux qui n'existe pas encore
     * actuellement n'est dispo qe pôur le vendeur
    */
    public function saveTicketEnCours(Request $request){
        if(isset($request->ticket['marchandises'])) {
            $employee_id = $request->session()->get('personnel_id');
            $id_depot = DataService::getComptoirDepotId($employee_id);
            $qtenegatives = DataService::countQteNegative($request->ticket['marchandises']);
            $flag = DataService::checkEmployeeCanReturnMarch($employee_id);
            if($qtenegatives == 0){
                $ref_transaction = $this->newVenteTicket($employee_id, $id_depot, $request);
                $to_print = array("ref"=>$ref_transaction, "marchs"=>$request->ticket['marchandises']);
                return response()->json($to_print, 200);
            }else if($qtenegatives > 0 && $flag == true){
                $ref_transaction = $this->newVenteTicket($employee_id, $id_depot, $request);
                $to_print = array("ref"=>$ref_transaction, "marchs"=>$request->ticket['marchandises']);
                return response()->json($to_print, 200);
            }else{
                return response()->json(["res" => "vous n'etes pas authorisé a faire des facture negatives"]);
            }
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
    public function updateStockforTicketEnCour($marchs, $id_depot, $today){
        foreach($marchs as $march){
            $id_march = Marchandise::getMarchId($march["name"]);
            $stock = Stockdepot::where('depot_id',$id_depot)->where('marchandise_id',$id_march)->first();
            StockService::updatStockMarchandise($stock, $march["quantite"], "Sortie", $today);
        }
    }


    public function newVenteTicket($employee_id, $id_depot, $request){
        $today = new DateTime();
        $last_ticket = VentecomptoirService::findWaitingTicket($request->ticket['codeticket']);
        if(is_null($last_ticket)){
            $ticket = VentecomptoirService::newTicket($request->ticket['codeticket'], $request->ticket['client'], 'en cours', $request->ticket['total'], $employee_id, $today);
            $ref_transaction = $ticket->code_ticket;
            DataService::newTransaction($ticket->code_ticket, $request->ticket['marchandises'], $today);
        }else{
            $ref_transaction = $last_ticket->code_ticket;
            VentecomptoirService::validateWaitingTicket($last_ticket, $request->ticket['total']);
            DataService::updateTransactionAddLines($last_ticket->code_ticket, $request->ticket['marchandises'], $today);
        }
        $this->updateStockforTicketEnCour($request->ticket['marchandises'], $id_depot, $today);
        return $ref_transaction;
    }

    public function launchprintScreen(){
        echo "<script>window.open('/print-ticket', '_blank')</script>";
    }

    
}
// dd($details);
// $ticket = Ticket::
// dd("enter");
// ==============
// $ticket_tmp = Cookie::get('ticketToPrint');
// dd($ticket_tmp);
// ==============
// $ticket_tmp = json_decode($ticket_tmp, true);
// dd($ticket);
// $ticket = array($ticket_tmp["ref"], $ticket_tmp["marchs"]);
// return response()->json($ticket, 200);
// ===========================================================================
// $to_print = array("ref"=>$ref_transaction, "marchs"=>$request->ticket['marchandises']);
// Cookie::queue('ticketToPrint', json_encode($to_print), 2);
// return redirect('/print');
// return PrintService::Sendprint($ref_transaction, $request->ticket['marchandises']);
// =========================================================================================
// $this->printTicket($to_print);
// dd($to_print);
// Cookie::queue('ticketToPrint', json_encode($to_print), 2);
// if($ref_transaction){ 
//     return response()->json(["res" => "warning: error on print"]);   
// }
// return redirect('/print');
// return response()->json(["res" => "successful: saved and printed"]);
// ================================================================================
// dd($to_print);
// Cookie::queue('ticketToPrint', json_encode($to_print), 2);
// if($ref_transaction){ 
//     return response()->json(["res" => "warning: error on print"]);   
// }
// return redirect('/print');
// return response()->json(["res" => "successful: saved and printed"]);
// ===========================================================================
// if($statut_caisse == true){
//     return view('comptoir.ventesComptoir')->with(compact('client_comptoir'))->with(compact('nouveau_code'));
// }else{
//     $caisse = Caisse::find($comptoir->caisse->id);
//     $caisse->statut == "ouvert";
//     $caisse->save();
//     return view('comptoir.ventesComptoir')->with(compact('client_comptoir'))->with(compact('nouveau_code'));
// }
       