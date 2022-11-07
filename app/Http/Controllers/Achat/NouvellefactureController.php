<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Depot;
use App\Models\Compte;
use App\Models\Marchandise;
use App\Models\Fournisseur;
use App\Models\Detailcompte;
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
        $depots = Depot::all();
        return view('achat.nouvelleFacture')->with(compact('depots'));
    }

    public function addmarchandise(Request $request){
        $march_exist = Marchandise::where('designation', $request->designation)->exists();
        if($march_exist){
            $is_full = $this->stock->stockMarchFull($request->designation);
            if($is_full){
                return response()->json(['error'=> 'La quantité en stock de ce produit est déja optimal.'],400);
            }else{
                $produit = Marchandise::where('designation',$request->designation)->select('reference','designation','prix_achat','dernier_prix_achat')->first();
                return response()->json(['success'=> $produit]);
            }
        }else{
            return response()->json(['error'=> 'Produit introuvable'],404);
        }
    }
    
    // operation compta:  new ligne credit compte fournisseur - update solde compte fournisseur - update journal achat
    public function savefacture(Request $request){
        $today= new DateTime();
        $depotid = $request->facture['depot'];
       
        if(array_key_exists('marchandises', $request->facture)){
            $fourni = $this->achat->getFourni($depotid, $request->facture['fournisseur']);
            if($fourni){
                // creation: achat, mouvement et transaction
                $marchandises = $request->facture['marchandises'];
                $fac =  $this->achat->newFacture($fourni->id, $request->facture['codefac'],$request->facture['total'],$request->facture['remise'],$request->facture['net'],$today);
                $res = DataService::newTransaction($fac->code_facture, $marchandises, $today);
                $mvts = $this->stock->newMvtEntreeSortie($depotid, $fac->code_facture, $marchandises, "Entrée");
    
                $qteegatives = collect($marchandises)->filter(function($item){ return $item['quantite'] < 0; })->count();
                if($qteegatives == 0 || $request->facture['net'] > 0){
                    $this->stock->updateCmupDernierPrixAchat($marchandises);
                    $numcompte_founi = $this->achat->updateComptaFournisseurs($fourni, $fac->code_facture, $fac->montant_net, $today, 'Crédit');
                    $this->achat->updateJournalAchat($fac, $numcompte_founi);
                }else if($qteegatives == collect($marchandises)->count()){
                    $numcompte_founi = $this->achat->updateComptaFournisseurs($fourni, $fac->code_facture, abs($fac->montant_net), $today, 'Débit');
                    // ajouter code pour debiter compte caisse
                }
                // marque debit compt march
                foreach($marchandises as $march){
                    $compte = Compte::where('numero_compte','LIKE','601%')->where('intitule',$march['name'])->first();
                    if($compte){
                        $detail_caisse = new Detailcompte;
                        $detail_caisse->numero_compte = $compte->numero_compte;
                        $detail_caisse->reference_operation = 'Achat marchandise '. $march['name'];
                        $detail_caisse->date_operation = $today;
                        $detail_caisse->debit = $march['prix'];
                        $detail_caisse->save();
                    }
                }
                return redirect('/nouvelleFacture');
            }else{
                return response()->json(['error'=> 'Fournisseur introuvable'], 404);
            }
        }else{
            return response()->json(['error'=> 'Erreur: Facture vide'], 401);
        }

    }
}
