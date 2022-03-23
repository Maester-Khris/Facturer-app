<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AchatService;

class ComptefournisseurController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        return view('achat.interrogerCompteFournisseur');
    }

    public function activities(Request $request){
        $activities = $this->achat->ProviderActivities(1, $request->fournisseur);
        // dd($activities);
        $solde = $this->achat->getFourniSolde($request->fournisseur);
        return response()->json(["success" => [ $activities, $solde] ]);
    }
}
