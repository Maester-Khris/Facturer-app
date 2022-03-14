<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;

class InventaireController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
       $lignes = $this->stock->listInventory(1);
       //dd($lignes);
       return view('stock.inventaire')->with(compact('lignes'));
   }

   public function newLigne(Request $request){
    $request->validate([
        'produit' => 'required',
        'newqte' => 'required',
    ]);
    $this->stock->newLigneInventaire($request->produit, $request->newqte);
    return redirect('/inventaire');
   }
}
