<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use App\Services\AchatService;
use Illuminate\Http\Request;
use App\Models\Facture;


class ReglementFactureController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        $impayes =  $this->achat->ListUnSoldedFactures(1);  
        // dd($impayes);
        return view('achat.reglement')->with(compact('impayes'));
    }

    public function soldbills(Request $request){
        $this->achat->soldBill($request->fournisseur, $request->codefacture, $request->demo3);
        return redirect('/reglementFacture');
    }
}
