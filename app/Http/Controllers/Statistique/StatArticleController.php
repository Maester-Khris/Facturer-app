<?php

namespace App\Http\Controllers\Statistique;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Services\StockService;
use App\Services\DataService;

class StatArticleController extends Controller
{
    private $stock;
    public function __construct(StockService $stock)
    {
        $this->stock = $stock;
    }

    public function index(Request $request)
    {
        // $employee_id = $request->session()->get('personnel_id');
        // $comptoir = DataService::getComptoirPersonnel($employee_id);
        // $data = DataService::getStatsVenteArticles($comptoir->depot->id);
        // // dd($data) ;
        // $data2 = DataService::getStatGenerale(1);
        // $facture_ventes = $data2[0];
        // $ticket = $data2[1];
        // $chiffre_affaire = $data2[2];
        // $marge = $data2[3];
        
        return view('statistique.palmares');
        // ->with(compact('data'))
        // ->with(compact('facture_ventes'))
        // ->with(compact('ticket'))
        // ->with(compact('chiffre_affaire'))
        // ->with(compact('marge'));
    }

    public function getStatDepot(Request $request){
        $employee_id = $request->session()->get('personnel_id');
        $comptoir = DataService::getComptoirPersonnel($employee_id);
        $data = DataService::getStatsVenteArticles($comptoir->depot->id, $request->periode_min, $request->periode_max);
        // dd($data) ;
        $data2 = DataService::getStatGenerale($comptoir->depot->id, $request->periode_min, $request->periode_max);
        $facture_ventes = $data2[0];
        $ticket = $data2[1];
        $chiffre_affaire = $data2[2];
        $marge = $data2[3];
        
        return view('statistique.palmares')->with(compact('data'))
        ->with(compact('facture_ventes'))
        ->with(compact('ticket'))
        ->with(compact('chiffre_affaire'))
        ->with(compact('marge'));
    }
}
