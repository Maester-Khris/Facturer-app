<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Depot;
use App\Models\Client;
use App\Models\Compte;
use App\Models\Comptoir;
use App\Models\Marchandise;
use App\Models\Detailcompte;
use App\Services\VenteService;
use App\Services\StockService;
use App\Services\DataService;
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

    public function index(Request $request){
        $depots = Depot::all();
        return view('vente.nouvelleFactureVente')->with(compact('depots'));
    }

    public function addmarchandise(Request $request){
        $march_exist = Marchandise::where('designation', $request->designation)->exists();
        if($march_exist){
            $verif = $this->stock->stockMarchDisponibility($request->depot, $request->designation,$request->quantite);
            if(is_null($verif)){
                return response()->json(['error'=> 'Produit introuvable ou quantité en stock insuffisante.'],400);
            }else{
                $produit = Marchandise::where('designation',$request->designation)->select('id','reference','designation','prix_vente_detail','prix_vente_gros')->first();
                return response()->json(['success'=> $produit]);
            }
        }else{
            return response()->json(['error'=> 'Produit introuvable'],404);
        }
       
    }

    public function savefacture(Request $request){
        // initialization
        $montant = [];
        $montant[0] = $request->facture['remise'];
        $montant[1] = $request->facture['total'];
        $montant[2] = $request->facture['net'];
        $today = new DateTime();
        $depotid = $request->facture['depot'];

        if(array_key_exists('marchandises', $request->facture)){            
            $client = Client::getClient($request->facture['client'],$depotid);
            if($client){
                // creation vente, mouvement et transaction
                $marchandises = $request->facture['marchandises'];
                $vente =  $this->vente->newVente($client->id, $request->facture['codevente'], $montant, $today);
                $res = DataService::newTransaction($vente->code_vente, $marchandises, $today);        
                $mvts = $this->stock->newMvtEntreeSortie($depotid, $vente->code_vente, $marchandises, "Sortie");
    
                // operation comptable et journal vene
                $qteegatives = collect($marchandises)->filter(function($item){ return $item['quantite'] < 0; })->count();
                if($qteegatives == 0 || $request->facture['net'] > 0){
                    $numero_compte = $this->vente->updateComptaClient($client, $vente->code_vente, $request->facture['net'], $today, "Débit");
                    $this->vente->updateJournalVente($numero_compte, $vente);
                }else if($qteegatives == collect($marchandises)->count()){
                    $id_compteclient = $this->vente->updateComptaClient($client, $vente->code_vente, abs($request->facture['net']), $today, "Crédit");
                    // ajouter code pour crediter compte caisse apres avoir lié compte caisse et caisse
                }
    
                // marque credit compt march
                foreach($marchandises as $march){
                    $compte = Compte::where('numero_compte','LIKE','701%')->where('intitule',$march['name'])->first();
                    if($compte){
                        $detail_caisse = new Detailcompte;
                        $detail_caisse->numero_compte = $compte->numero_compte;
                        $detail_caisse->reference_operation = 'Vente marchandise '. $march['name'];
                        $detail_caisse->date_operation = $today;
                        $detail_caisse->credit = $march['prix'];
                        $detail_caisse->save();
                    }
                }
                return response()->json(['success'=> "ok"]);
            }else{
                return response()->json(['error'=> 'Client introuvable'],404);
            }
        }else{
            return response()->json(['error'=> 'Erreur: Facture vide'], 401);
        }
        

        

    }
}
