<?php

namespace App\Http\Controllers\Achat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AchatService;

class ListefactureController extends Controller
{
    //
    private $achat;
    public function __construct(AchatService $achat){
        $this->achat = $achat;
    }

    public function index(){
        $factures =  $this->achat->listFacture(1);
        // dd($factures);
        return view('achat.facturesFournisseur')->with(compact('factures'));
    }
}
