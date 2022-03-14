<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventaire;
use App\Services\StockService;

class TestController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
        return $this->stock->sayHello();
    }
}
