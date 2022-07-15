<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Models\Mouvementstock;
use DateTime;

class SituationdepotController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
      $this->stock = $stock;
    }

   public function index(){
      $articles = $this->stock->situationDepot(1);
      return view('stock.listeinventaire')->with(compact('articles'));
   }

   public function indexwitherror(){
      $articles = $this->stock->situationDepot(1);
      $transf_error = "Produit introuvable ou quantité en stock insuffisante";
      return back()->with('error',$transf_error);
   }

   public function transferMarch(Request $request){
      $request->validate([
         'destination' => 'required',
         'produit' => 'required',
         'demo3' => 'required',
      ]);

      // verifier quantite disponilbe en stock avant de transferer
      $verif = $this->stock->stockMarchDisponibility($request->produit,$request->demo3);
      if (is_null($verif)) {
         // return response()->json(['error'=> 'Produit introuvable ou quantité en stock insuffisante.'],400);
         return redirect("/transfer-error");
      } else{
         $today = new DateTime();;
         $this->stock->newTransfer($request->produit, $request->demo3, $request->destination, $today);
         return redirect('/situiationDepots');
      }
   }

   public function reajustMarchStock(Request $request){
      $request->validate([
         'produit' => 'required',
         'demo3' => 'required',
      ]);

      $today = new DateTime();
      $this->stock->reajustMarch($request->produit, $request->demo3, $today);
      return redirect('/situiationDepots');
      // return response()->json(['test' => $request->produit]);
   }
}
