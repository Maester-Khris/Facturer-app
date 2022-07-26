<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaire;
use App\Models\Detailtransactions;
use App\Services\StockService;

class TestController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
        // return $this->stock->sayHello();
        $transaction = Detailtransactions::where("reference_transaction","TKT0002")
                  ->where("reference_marchandise", "REF0004")->first();
                  dd($transaction);
    }
}
