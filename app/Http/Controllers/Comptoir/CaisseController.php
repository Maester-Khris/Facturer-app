<?php

namespace App\Http\Controllers\Comptoir;

use Illuminate\Http\Request;
use App\Models\Caisse;
use App\Services\DataService;
use App\Services\VentecomptoirService;
use App\Http\Controllers\Controller;

class CaisseController extends Controller
{
    public function index(){
        $caisses = Caisse::all();
        return view('comptoir.operationComptoir')->with(compact('caisses'));
    }

    public function getStatut(Request $request){
        $caisse_id = $request->caisse_id;
        $caisse = Caisse::find($caisse_id);
        if($caisse){
            $res = DataService::checkCaisseOpened($caisse->id);
            if($res == true){
                return response()->json(["res" => "ouvert"]);
            }else{
                return response()->json(["res" => "ferme"]);
            }
        }
    }

    // doit etre modifie pour prendre en compte le depot 
    // et le fait que le ref sont par depot sauf pour les march
    public function getDetailTicket(Request $request){
        $employee_id = $request->session()->get('personnel_id');
        $comptoir = DataService::getComptoirPersonnel($employee_id);
        $details = DataService::detailsTransaction('Ticket',$request["code"],$comptoir->depot->id);
        // dd($details);
        return response()->json($details);
    }

    public function toggleStatut(Request $request){
        $caisse_id = $request->caisse_id;
        $caisse = Caisse::find($caisse_id);
        if($caisse){
            if($caisse->statut == "ouvert"){
                $this->closeCaisse($caisse);
                return redirect('/');
            }else{
                $this->openCaisse($caisse);
                return redirect('/ventesComptoir');
            }
        }
    }

    public function interrogerCaisse(Request $request){
        $caisses = Caisse::all();
        $caisse = Caisse::find($request->caisse);
        if($caisse){
            $data = VentecomptoirService::getTicketArchiveByPeriod($caisse, $request->periode_min, $request->periode_max);
            return view('comptoir.operationComptoir')->with(compact('caisses'))->with(compact('data'));
        }else{
            $transf_error = "Aucune correspondance, verifiez le formalaire";
            return back()->with('error_form_caisse',$transf_error);
        }
    }

    public function openCaisse($caisse){
        $caisse->statut = "ouvert";
        $caisse->save();
    }
    public function closeCaisse($caisse){
        $caisse->statut = "ferme";
        $caisse->save();
        VentecomptoirService::closeCaisseFactureVentes($caisse);
    }

    // $employee_id = $request->session()->get('personnel_id');
    // $comptoir = DataService::getComptoirPersonnel($employee_id);
    // $caisse = $comptoir->caisse;
}
