<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VenteService;
use App\Models\Client;

class CompteclientController extends Controller
{
    //
    private $vente;
    public function __construct(VenteService $vente){
        $this->vente = $vente;
    }

    public function index(){
        $clients = Client::allDepotClient(1); ## ajouter juste pour faciliter les test
        return view('vente.interrogerCompteClient')->with(compact('clients'));
    }

    public function activities(Request $request){
        $activities = $this->vente->ClientActivities(1, $request->client);
        // dd($activities);
        $solde = $this->vente->getClientSolde($request->client);
        return response()->json(["success" => [ $activities, $solde] ]);
    }
}
