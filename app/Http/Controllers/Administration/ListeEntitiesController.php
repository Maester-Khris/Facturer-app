<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Marchandise;
use App\Models\Compte;
use App\Models\Personnel;
use App\Models\Depot;
use App\Models\Client;
use App\Models\Caisse;
use App\Models\Comptoir;
use App\Models\Fournisseur;



class ListeEntitiesController extends Controller
{
    public function index(){
        $depots = Depot::all();
        return view('administration.listesEntites')->with(compact('depots'));
    }

    public function getListeEntite(Request $request){
        $depots = Depot::all();
        $selecteddepot = $request->depot;
        $depot = Depot::getDepotById($selecteddepot);

        $marchs = Marchandise::all();
        $employees = Personnel::getEmployeeByDepot($request->depot);
        $fournis = Fournisseur::getByDepot($request->depot);
        $clients = Client::allDepotClientWithoutDefaults($request->depot);
        $comptoirs = Comptoir::where('depot_id',$request->depot)->get();
        $caisses = Caisse::where('depot_id',$request->depot)->get();
        $comptes = Compte::whereIn('type',['general','charge','produit'])
            ->where('intitule','LIKE','%'.$depot->nom_depot.'%')
            ->get();

        return view('administration.listesEntites')->with(compact('depots'))->with(compact('selecteddepot'))
        ->with(compact('marchs'))->with(compact('employees'))
        ->with(compact('fournis'))->with(compact('clients'))
        ->with(compact('comptoirs'))->with(compact('caisses'))
        ->with(compact('comptes'));
    }
}
