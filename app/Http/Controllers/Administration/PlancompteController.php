<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Compte;
use App\Models\Depot;

class PlancompteController extends Controller
{
    public function index(Request $request){
        // $selecteddepot = $request->depot;
        // $depot = Depot::getDepotById($selecteddepot);
        $depots = Depot::all();
        
        $comptemarchs = Compte::where('numero_compte','LIKE','601%')
            ->orWhere('numero_compte','LIKE','701%')->get();
        
        $compteclients = Compte::where('numero_compte','LIKE','411%')
            // ->join('clients','comptes.intitule','=','clients.nom_complet')
            // ->where('clients.depot_id',$request->depot)
            ->get();

        $comptefours = Compte::where('numero_compte','LIKE','401%')
            // ->join('fournisseurs','comptes.intitule','=','fournisseurs.nom_complet')
            // ->where('fournisseurs.depot_id',$request->depot)
            ->get();
    
        $comptecaisses= Compte::where('numero_compte','LIKE','571%')
            // ->join('caisses','comptes.intitule','=','caisses.libelle')
            // ->where('caisses.depot_id',$request->depot)
            ->get();

        $compteautres = Compte::whereIn('type',['general','charge','produit'])
            // ->where('intitule','LIKE','%'.$depot->nom_depot.'%')
            ->get();

        return view('administration.planCompte')->with(compact('depots'))
            ->with(compact('comptemarchs'))->with(compact('compteclients'))
            ->with(compact('comptefours'))->with(compact('comptecaisses'))
            ->with(compact('compteautres'));
    }

    // public function index(){
    //     $depots = Depot::all();
    //     return view('administration.planCompte')->with(compact('depots'));
    // }
    // public function getPlanCompte(Request $request){}
}
