<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use DateTime;

class InventaireController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
       return view('stock.saisieinventaire');
   }

   public function listinventaire(){
        $lignes = $this->stock->listInventory(1);
        return view('stock.listeinventaire')->with(compact('lignes'));
   }

   public function newSaisie(Request $request){
        $this->stock->newSaisieInventaire($request["marchs"]) ;
        return redirect('/inventaire');
   }

   public function getDetailsIvts(Request $request){
        $articles = $this->stock->detailsInventaire(1,$request["code"]);
        return response()->json($articles);
   }
}
