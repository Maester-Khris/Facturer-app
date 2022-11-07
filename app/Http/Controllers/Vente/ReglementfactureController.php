<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Depot;
use App\Models\Caisse;
use App\Models\Client;
use App\Services\VenteService;

class ReglementfactureController extends Controller
{
    //
    private $vente;
    public function __construct(VenteService $vente){
        $this->vente = $vente;
    }

    public function index(){
        $depots = Depot::all();
        return view('vente.reglement')->with(compact('depots'));
    }
    public function listfactureimpayes(Request $request){
        $caisses = Caisse::all();
        $depots = Depot::all();
        $impayes = $this->vente->ListNonPaidVentes($request->depot);
        $selecteddepot=$request->depot;
        // dd($impayes);
        // on prend toute les vente qui ont une ecriture dans journal ventes et on selectin
        // celle qui ont le statut 0 et les client dans notre depot
        return view('vente.reglement')->with(compact('selecteddepot'))->with(compact('depots'))->with(compact('caisses'))->with(compact('impayes'));
    }

    public function soldvente(Request $request){
        // dd($request->depot);
        $client = Client::getClient($request->client,$request->depot);
        $this->vente->soldVente($client, $request->codevente, $request->demo3, $request->caisse);
        return redirect('/reglementFactureVente');
    }
}
