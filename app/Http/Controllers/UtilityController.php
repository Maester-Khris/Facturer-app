<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    private $data;
    public function __construct(DataService $data){
      $this->data = $data;
    }

    public function suggestproduct(Request $request)
    {
      $data = $this->data->Marchandisesuggestion($request->produit);
      return response()->json($data);
    }

    public function suggestclient(Request $request)
    {
      $data = $this->data->Clientsuggestion($request->client);
      return response()->json($data);
    }

    public function stockmarchandiseinfo(Request $request){
      $data = $this->data->Marchandisestockinfo($request->produit);
      return response()->json($data);
    }

}
