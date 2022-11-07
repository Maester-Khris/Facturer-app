<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depot;
use App\Services\AchatService;

class ListefactureController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        $depots = Depot::all();
        return view('achat.facturesFournisseur')->with(compact('depots'));
    }
    
    public function listfacture(Request $request){
        $depots = Depot::all();
        $selecteddepot=$request->depot;
        $factures =  $this->achat->listFacture($request->depot);
        return view('achat.facturesFournisseur')->with(compact('selecteddepot'))->with(compact('depots'))->with(compact('factures'));
    }
}
