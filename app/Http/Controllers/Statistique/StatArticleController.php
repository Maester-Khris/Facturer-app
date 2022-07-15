<?php

namespace App\Http\Controllers\Statistique;

use App\Http\Controllers\Controller;
use App\Services\StockService;

class StatArticleController extends Controller
{
    private $stock;
    public function __construct(StockService $stock)
    {
        $this->stock = $stock;
    }

    public function index()
    {
        $data = $this->stock->getStatsVenteArticles(1);
        $data2 = $this->stock->getStatGenerale(1);
        $facture_ventes = $data2[0];
        $ticket = $data2[1];
        $chiffre_affaire = $data2[2];
        $marge = $data2[3];
        
        return view('statistique.statArticle')->with(compact('data'))
        ->with(compact('facture_ventes'))
        ->with(compact('ticket'))
        ->with(compact('chiffre_affaire'))
        ->with(compact('marge'));
    }
}
