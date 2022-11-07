<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depot;
use App\Services\VenteService;

class ListefactureController extends Controller
{
    //
    private $vente;
    public function __construct(VenteService $vente){
        $this->vente = $vente;
    }

    public function index(){
        $depots = Depot::all();
        return view('vente.listeFacturesClient')->with(compact('depots'));
    }

    public function listfacture(Request $request){
        $depots = Depot::all();
        $selecteddepot=$request->depot;
        $ventes =  $this->vente->ListVente($request->depot);
        return view('vente.listeFacturesClient')->with(compact('selecteddepot'))->with(compact('depots'))->with(compact('ventes'));
    }
}
