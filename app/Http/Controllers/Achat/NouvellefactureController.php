<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marchandise;
use App\Services\AchatService;
use App\Services\StockService;
use Date;

class NouvellefactureController extends Controller
{
    private $achat;
    private $stock;
    public function __construct(AchatService $achat, StockService $stock){
        $this->achat = $achat;
        $this->stock = $stock;
    }

    public function index(){
        return view('achat.nouvelleFacture');
    }

    public function addmarchandise(Request $request){
        $produit = Marchandise::where('designation',$request->designation)->select('reference','designation','prix_achat','dernier_prix_achat')->first();
        return response()->json(['success'=> $produit]);
    }
    
    /**
     * get la date aujours
     * enregistrer la facture avec cette date
     * enregistrer les mouvements d'entree pour chacune de ces marchandises avec la meme date
     * operation compta: 
     *    new ligne credit compte fournisseur
     *    update solde compte fournisseur
     *    update journal achat
    */
    public function savefacture(Request $request){
        
        $today= date("Y-m-d");
        $fourni = $this->achat->getFourni($request->facture['fournisseur']);

        $fac =  $this->achat->newFacture(
            $fourni->id, 
            $request->facture['codefac'],
            $request->facture['total'],
            $request->facture['remise'],
            $request->facture['net'],
            $today
        );
        
        $marchandises = $request->facture['marchandises'];
        foreach($marchandises as $march){
            $this->stock->newEntree($march['name'], $march['quantite']);
        }

        $id_comptefourni = $this->achat->updateComptaFournisseurs($fourni->nom, $fac->montant_net, $today, 'Crédit');
        $this->achat->updateJournalAchat($fac, $id_comptefourni);
        return redirect('/nouvelleFacture');
    }
}
