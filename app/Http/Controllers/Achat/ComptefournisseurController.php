<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AchatService;
use App\Models\Fournisseur;

class ComptefournisseurController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        $fournisseurs = Fournisseur::getByDepot(1); ## ajouter juste pour faciliter les test
        return view('achat.interrogerCompteFournisseur')->with(compact('fournisseurs'));
    }

    public function activities(Request $request){
        $activities = $this->achat->ProviderActivities(1, $request->fournisseur);
        // dd($activities);
        $solde = $this->achat->getFourniSolde($request->fournisseur);
        return response()->json(["success" => [ $activities, $solde] ]);
    }
}
