<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;

class MouvementController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
      $mvts = $this->stock->allMouvements(1);
      return view('stock.mouvementsStock')->with(compact('mvts'));
   }

   public function nouvelleEntree(Request $request){
        $mvts = $this->stock->newMvtEntreeSortie($request["marchs"], "Entrée");
        return view('stock.mouvementsStock')->with(compact('mvts'));
   }

   public function nouvelleSortie(Request $request){
        $mvts = $this->stock->newMvtEntreeSortie($request["marchs"], "Sortie");
        return view('stock.mouvementsStock')->with(compact('mvts'));
    }

    public function nouveauTransfert(Request $request){
        $mvts = $this->stock->newMvtTransf($request["marchs"], $request["depot_destination"]);
        return view('stock.mouvementsStock')->with(compact('mvts'));
    }

    public function getDetailsMouvts(Request $request){
        $articles = $this->stock->detailsMouvement(1, $request["code"]);
        return response()->json($articles);
    }


}
