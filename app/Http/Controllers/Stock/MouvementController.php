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
      $mvts = $this->stock->allArticlesMouvements(1);
      return view('stock.mouvementsStock')->with(compact('mvts'));;
   }


}
