<?php

namespace App\Http\Controllers;

use App\Services\DataService;
use App\Models\Depot;
use App\Models\Facture;
use App\Models\Marchandise;
use App\Models\Vente;
use Illuminate\Http\Request;

class UtilityController extends Controller
{
    private $data;
    public function __construct(DataService $data){
      $this->data = $data;
    }

    public function verifymarchandise(Request $request){
      $march = Marchandise::where('designation', $request->produit)->first();
      if($march){
        return response()->json($march);
      }else{
        return response()->json(['error'=> 'Produit introuvable'],404);
      }
    }

    public function suggestproductMvt(Request $request){
      $data = $this->data->Marchandisesuggestion($request->produit);
      return response()->json($data);
    }

    public function suggestproduct(Request $request){
      $data = $this->data->MarchandiseDepotsuggestion($request->produit,$request->depot);
      return response()->json($data);
    }

    public function suggestproductForComptoir(Request $request){
      $employee_depot = $request->session()->get('depot_name');
      $depot = Depot::where('nom_depot', $employee_depot)->first();
      // dd($depot);
      $data = $this->data->MarchandisescompletionVente($request->produit, $depot->id);
      return response()->json($data);
    }

    public function suggestclient(Request $request){
      if($request->depot == "default"){
        // recuperer le depot du vendeur connecter
        $employee_depot = $request->session()->get('depot_name');
        $depot = Depot::where('nom_depot', $employee_depot)->first();
        $data = $this->data->Clientsuggestion($request->client, $depot->id);
      }else{
        $data = $this->data->Clientsuggestion($request->client, $request->depot);
      }
     
      return response()->json($data);
    }

    public function suggestfournisseur(Request $request){
      $data = $this->data->Fournisseursuggestion($request->fournisseur, $request->depot);
      return response()->json($data);
    }

    public function stockmarchandiseinfo(Request $request){
      // $march_exist = Marchandise::where('designation', $request->produit)->exists();
      $march_exist = Marchandise::where('designation', $request->produit)->first();
      if($march_exist){
        // $data = $this->data->Marchandisestockinfo($request->produit, $request->depot);
        $data = $this->data->Marchandisestockinfo($march_exist->reference, $request->depot);
        return response()->json($data);
      }else{
        return response()->json(['error'=> 'Produit introuvable'],404);
      }
    }

    public function getdetailFacture(Request $request){
      if($request->type == "achat"){
        $data = $this->data->detailsTransaction('Facture',$request->code, $request->depot);
        $fourni = Facture::getFournisseurAchat($request->code, $request->depot);

        // $fourni = Facture::where("code_facture",$request->code)
        // ->join("fournisseurs","factures.fournisseur_id","=","fournisseurs.id")
        // ->where("fournisseurs.depot_id",$request->depot)
        // ->select("fournisseurs.nom_complet")
        // ->get();
        // dd($fourni->nom_complet);
        return response()->json([$data, $fourni->nom_complet]);
      }elseif($request->type == "vente"){
        $data = $this->data->detailsTransaction('Vente',$request->code, $request->depot);
        $client = Vente::getClientVente($request->code, $request->depot);

        // $client = Vente::where("code_vente",$request->code)
        // ->join("clients","ventes.client_id","=","clients.id")
        // ->where("clients.depot_id",$request->depot)
        // ->select("clients.nom_complet")
        // ->get();

        return response()->json([$data, $client->nom_complet]);
      }
    }

    public function getActualCode(Request $request){
      if($request->type == "achat"){
        // $nbrows = Facture::countFactures($request->depot);
        $nbrows = Facture::count();
        $nouveau_code = DataService::genCode("Facture", $nbrows + 1);
      }elseif($request->type == "vente"){
        // $nbrows = Vente::countVentes($request->depot);
        $nbrows = Vente::count();
        $nouveau_code = DataService::genCode("Vente", $nbrows + 1);
      }
      return response()->json(["code" => $nouveau_code]);
    }

}
