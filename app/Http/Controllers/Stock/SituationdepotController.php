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
      // dd($situation);
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
      $this->stock->newTransfer($request->produit, $request->demo3, $request->destination);
      return redirect('/situiationDepots');
      // return response()->json(['success'=> $request]);
   }

   public function reajustMarchStock(Request $request){
      $request->validate([
            'produit' => 'required',
            'demo3' => 'required',
        ]);
      $this->stock->reajustMarch($request->produit, $request->demo3);
      return redirect('/situiationDepots');
   }
}
