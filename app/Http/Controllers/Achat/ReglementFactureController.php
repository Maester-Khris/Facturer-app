<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;

use App\Models\Depot;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Fournisseur;
use App\Services\AchatService;
use Illuminate\Http\Request;



class ReglementFactureController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){ 
        $depots = Depot::all();
        return view('achat.reglement')->with(compact('depots'));
    }

    public function listfactureimpayes(Request $request){
        $caisses = Caisse::all();
        $depots = Depot::all();
        $selecteddepot=$request->depot;
        $impayes =  $this->achat->ListUnSoldedFactures($request->depot); 
        return view('achat.reglement')->with(compact('selecteddepot'))->with(compact('depots'))->with(compact('caisses'))->with(compact('impayes'));
    }

    public function soldbills(Request $request){
        $fournisseur = Fournisseur::where('depot_id',$request->depot)->where('nom_complet',$request->fournisseur)->first();
        $this->achat->soldBill($fournisseur, $request->codefacture, $request->demo3, $request->caisse);
        return redirect('/reglementFacture');
    }
}
