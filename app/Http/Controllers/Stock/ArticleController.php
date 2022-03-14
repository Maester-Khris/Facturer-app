<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;

class ArticleController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

   public function index(){
      $articles = $this->stock->stockArticlesList(1);
      return view('stock.interrogerArticles')->with(compact('articles'));;
   }

   public function voirmarchandise(Request $request){
      $marchandise = $this->stock->marchandiseDetails($request->reference);
      // dd($marchandise);
      return response()->json(['success'=> $marchandise]);
   }
}
