<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AchatService;
use App\Models\Fournisseur;
use App\Models\Depot;

class ComptefournisseurController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        $depots = Depot::all();
        return view('achat.interrogerCompteFournisseur')->with(compact('depots'));
    }

    public function activities(Request $request){
        $depots = Depot::all();
        $activities = $this->achat->ProviderActivities($request->depot, $request->fournisseur);
        $selecteddepot= $request->depot;
        $selectedfourni = $request->fournisseur;
        $solde = $this->achat->getFourniSolde($request->depot, $request->fournisseur);
        return view('achat.interrogerCompteFournisseur')
        ->with(compact('selecteddepot'))->with(compact('selectedfourni'))
        ->with(compact('activities'))->with(compact('depots'))->with(compact('solde'));
    }
}
