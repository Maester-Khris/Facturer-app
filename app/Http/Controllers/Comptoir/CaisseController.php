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

  
    public function getDetailTicket(Request $request){
        $caisse = Caisse::where('libelle',$request["caisse"])->first();
        $details = DataService::detailsTransaction('Ticket',$request["code"],$caisse->depot_id);
        return response()->json($details);
    }

    public function toggleStatut(Request $request){
        $caisse_id = $request->caisse_id;
        $caisse = Caisse::find($caisse_id);
        if($caisse){
            if($caisse->statut == "ouvert"){
                $res = DataService::checkVendeursCaisseLoggedout($caisse);
                if($res == true){
                    $this->closeCaisse($caisse);
                    return redirect('/operationCaisse');
                }else{
                    $caisse_error = "Probleme lors de la fermeture: Vendeurs encore en ligne";
                    return back()->with('error_form_caisse',$caisse_error);
                }
            }else{
                $this->openCaisse($caisse);
                return redirect('/operationCaisse');
            }
        }
    }

    public function interrogerCaisse(Request $request){
        $caisses = Caisse::all();
        $caisse = Caisse::find($request->caisse);
        if($caisse){
            $data = VentecomptoirService::requestTicketCaisse($caisse, $request->type_ticket, $request->periode_min, $request->periode_max);
            $type = $request->type_ticket == 'archive' ? 'Archivé' : 'En Cours';
            $total =  !$data->isEmpty() ? $data->sum('total') : 0; 
            return view('comptoir.operationComptoir')
            ->with(compact('caisses'))
            ->with(compact('caisse'))
            ->with(compact('type'))
            ->with(compact('total'))
            ->with(compact('data'));
        }
        else{
            $caisse_error = "Aucune correspondance, verifiez le formalaire";
            return back()->with('error_form_caisse',$caisse_error);
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
}
