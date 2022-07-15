<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marchandise;
use App\Models\Fournisseur;
use App\Services\AchatService;
use App\Services\StockService;
use App\Services\DataService;
use DateTime;

class NouvellefactureController extends Controller
{
    private $achat;
    private $stock;
    public function __construct(AchatService $achat, StockService $stock){
        $this->achat = $achat;
        $this->stock = $stock;
    }

    public function index(){
        $fournisseurs = Fournisseur::getByDepot(1); ## ajouter juste pour faciliter les test
        $nbrows = $this->achat->allDepotFactureCount(1);
        $code =  DataService::genCode("Facture", $nbrows + 1);
        return view('achat.nouvelleFacture')->with('code',$code)->with(compact('fournisseurs'));
    }

    public function addmarchandise(Request $request){
        $is_full = $this->stock->stockMarchFull($request->designation);
        if($is_full){
            return response()->json(['error'=> 'La quantité en stock de ce produit est déja optimal.'],400);
        }else{
            $produit = Marchandise::where('designation',$request->designation)->select('reference','designation','prix_achat','dernier_prix_achat')->first();
            return response()->json(['success'=> $produit]);
        }
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
        $today= new DateTime();
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
        $res = DataService::newTransaction($fac->code_facture, $marchandises);
        
        $this->stock->updateCmupDernierPrixAchat($marchandises);
        $mvts = $this->stock->newMvtEntreeSortie($marchandises, "Entrée");

        $id_comptefourni = $this->achat->updateComptaFournisseurs($fourni->nom, $fac->montant_net, $today, 'Crédit');
        $this->achat->updateJournalAchat($fac, $id_comptefourni);
        return redirect('/nouvelleFacture');
    }
}
