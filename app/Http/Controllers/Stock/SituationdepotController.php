<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Models\Mouvementstock;

class SituationdepotController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
      $this->stock = $stock;
    }

    public function index(){
      $articles = $this->stock->situationDepot(1);
      return view('stock.situiationDepots')->with(compact('articles'));
   }

   public function transferMarch(Request $request){
      $request->validate([
            'destination' => 'required',
            'produit' => 'required',
            'demo3' => 'required',
        ]);
        // $nbrows = Mouvementstock::all()->count();
        // dd($nbrows);
      $today = date("Y-m-d");
      $this->stock->newTransfer($request->produit, $request->demo3, $request->destination, $today);
      return redirect('/situiationDepots');
   }

   public function reajustMarchStock(Request $request){
      $request->validate([
            'produit' => 'required',
            'demo3' => 'required',
        ]);

      $today = date("Y-m-d");
      $this->stock->reajustMarch($request->produit, $request->demo3, $today);
      return redirect('/situiationDepots');
   }
}
