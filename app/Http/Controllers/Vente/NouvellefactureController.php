<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marchandise;
use App\Models\Client;
use App\Models\Comptoir;
use App\Services\VenteService;
use App\Services\StockService;
use Date;
use DateTime;

class NouvellefactureController extends Controller
{
    private $vente;
    private $stock;
    public function __construct(VenteService $vente, StockService $stock){
        $this->vente = $vente;
        $this->stock = $stock;
    }

    public function index(){
        return view('vente.nouvelleFactureVente');
    }

    public function addmarchandise(Request $request){
        $produit = Marchandise::where('designation',$request->designation)->select('reference','designation','prix_vente_detail','prix_vente_gros')->first();
        return response()->json(['success'=> $produit]);
    }

    public function savefacture(Request $request){
        $montant = [];
        $montant[0] = $request->facture['remise'];
        $montant[1] = $request->facture['total'];
        $montant[2] = $request->facture['net'];

        $today = new DateTime();
        $client = Client::getClient($request->facture['client'],1);
        $marchandises = $request->facture['marchandises'];

        $vente =  $this->vente->newVente(
            $client->id, 
            Comptoir::getComptoirId($request->facture['comptoir'], 1),
            $request->facture['codevente'],
            $montant,
            $marchandises,
            $today
        );
        
        foreach($marchandises as $march){
            $this->stock->newSortie($march['name'], $march['quantite']);
        }
        
        $id_compteclient = $this->vente->updateComptaClient($client, $request->facture['net'], $today, "Débit");
        $this->vente->updateJournalVente($id_compteclient, $vente, $request->facture['net']);
        return response()->json(['success'=> "ok"]);
        
    }
}
