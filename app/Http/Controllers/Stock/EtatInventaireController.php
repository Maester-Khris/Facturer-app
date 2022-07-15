<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;

class EtatInventaireController extends Controller
{
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(){
        $etats = $this->stock->NewEtatInventaireWithValorisation(1,"prix_achat");
        $prices = $etats->map(function($ligne){
            return $ligne->prix_achat;
        });
        $total = $this->getTotalVal1($etats);
        $valorisation = "type1";
        return view('stock.etatInventaire')
            ->with(compact('etats'))->with(compact('total'))
            ->with(compact('valorisation'));
    }

    public function nouvelEtat(Request $request){
        if($request->option_valorisation == "normal"){
            $etats = $this->stock->NewEtatInventaireWithValorisation(1,"prix_achat");
            $prices = $etats->map(function($ligne){
                return $ligne->prix_achat;
            });
            $valorisation = "type1";
            $total = $this->getTotalVal1($etats);
        }
        if($request->option_valorisation == "dernier"){
            $etats = $this->stock->NewEtatInventaireWithValorisation(1,"dernier_prix_achat");
            $prices = $etats->map(function($ligne){
                return $ligne->dernier_prix_achat;
            });
            $valorisation = "type2";
            $total = $this->getTotalVal2($etats);
        }
        if($request->option_valorisation == "cmup"){
            $etats = $this->stock->NewEtatInventaireWithValorisation(1,"cmup");
            $prices = $etats->map(function($ligne){
                return $ligne->cmup;
            });
            $valorisation = "type3";
            $total = $this->getTotalVal3($etats);
        }
        if($request->option_valorisation == "standart"){
            $etats = $this->stock->NewEtatInventaire(1);
            $total = 0;
            $valorisation = "type0";
        }

        return view('stock.etatInventaire')
            ->with(compact('etats'))->with(compact('total'))
            ->with(compact('valorisation'));
    }



    public static function getTotalVal1($etats){
        $total = $etats->reduce(function ($current, $ligne) {
            return $current + ($ligne->prix_achat * $ligne->quantite_stock);
        },0);
        return $total;
    }
    public static function getTotalVal2($etats){
        $total = $etats->reduce(function ($current, $ligne) {
            return $current + ($ligne->dernier_prix_achat * $ligne->quantite_stock);
        },0);
        return $total;
    }
    public static function getTotalVal3($etats){
        $total = $etats->reduce(function ($current, $ligne) {
            return $current + ($ligne->cmup * $ligne->quantite_stock);
        },0);
        return $total;
    }

}
