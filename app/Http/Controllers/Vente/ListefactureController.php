<?php

namespace App\Http\Controllers\Vente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\VenteService;

class ListefactureController extends Controller
{
    //
    private $vente;
    public function __construct(VenteService $vente){
        $this->vente = $vente;
    }

    public function index(){
        $ventes =  $this->vente->ListVente(1);
        return view('vente.listeFacturesClient')->with(compact('ventes'));
        // return response()->json(['success'=> $alls]);
    }
}
