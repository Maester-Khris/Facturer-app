<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VenteService;
use App\Models\Client;
use App\Models\Depot;

class CompteclientController extends Controller
{
    //
    private $vente;
    public function __construct(VenteService $vente){
        $this->vente = $vente;
    }

    public function index(){
        $depots = Depot::all();
        return view('vente.interrogerCompteClient')->with(compact('depots'));
    }

    public function activities(Request $request){
        $depots = Depot::all();
        $activities = $this->vente->ClientActivities($request->depot, $request->client);
        $selecteddepot=$request->depot;
        $selectedclient = $request->client;
        $solde = $this->vente->getClientSolde($request->client);
        return view('vente.interrogerCompteClient')
        ->with(compact('selecteddepot'))->with(compact('selectedclient'))
        ->with(compact('activities'))->with(compact('depots'))->with(compact('solde'));
    }
}
