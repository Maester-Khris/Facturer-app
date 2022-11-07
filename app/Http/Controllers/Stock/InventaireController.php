<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Models\Depot;
use DateTime;

class InventaireController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
       $depots = Depot::all();
       return view('stock.saisieinventaire')->with(compact('depots'));
   }

   public function listinventaire(){
          $depots = Depot::all();
        return view('stock.listeinventaire')->with(compact('depots'));
   }

   public function inventaireOperations(Request $request){
          $depots = Depot::all();
          $lignes = $this->stock->listInventory($request->depot);
          $selecteddepot = $request->depot;
          return view('stock.listeinventaire')->with(compact('lignes'))->with(compact('depots'))->with(compact('selecteddepot'));
   }

   public function newSaisie(Request $request){
        $this->stock->newSaisieInventaire($request["marchs"], $request->depot) ;
        return response()->json(["res" => "succeed"], 200);
   }

   public function getDetailsIvts(Request $request){
        $articles = $this->stock->detailsInventaire($request->depot,$request["code"]);
        return response()->json($articles);
   }
}
