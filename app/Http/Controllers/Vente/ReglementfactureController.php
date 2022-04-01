<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $impayes = $this->vente->ListNonPaidVentes(1);
        // dd($impayes);
        // return response()->json(['success'=> $impayes]);
        return view('vente.reglement')->with(compact('impayes'));
    }

    public function soldvente(Request $request){
        $client = Client::getClient($request->client,1);
        $this->vente->soldVente($client, $request->codevente, $request->demo3);
        return redirect('/reglementFactureVente');
    }
}
