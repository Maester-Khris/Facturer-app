<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Models\Depot;

class MouvementController extends Controller
{
    //
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(Request $request){
        $employee_depot = $request->session()->get('depot_name');
        $depot = Depot::where('nom_depot', $employee_depot)->first();
      $mvts = $this->stock->allMouvements($depot->id);
      $depots = Depot::all();
      return view('stock.mouvementsStock')->with(compact('mvts'))->with(compact('depots'));
   }

   public function transfert(Request $request){
    $employee_depot = $request->session()->get('depot_name');
    $depot = Depot::where('nom_depot', $employee_depot)->first();
    $transfertmvts = $this->stock->allTransferts($depot->id);
    // dd($transfertmvts);
    
    $othersdepots = Depot::where('nom_depot','!=' , $employee_depot)->get();
    return view('stock.transfertsStock')->with(compact('transfertmvts'))->with(compact('othersdepots'));
   }

   public function nouvelleEntree(Request $request){
        $depot = Depot::where("nom_depot",$request["depot"])->first();
        $mvts = $this->stock->newMvtEntreeSortie($depot->id, $request["marchs"], "Entrée");
        return view('stock.mouvementsStock')->with(compact('mvts'));
   }

   public function nouvelleSortie(Request $request){
        $depot = Depot::where("nom_depot",$request["depot"])->first();
        $mvts = $this->stock->newMvtEntreeSortie($depot->id, $request["marchs"], "Sortie");
        return view('stock.mouvementsStock')->with(compact('mvts'));
    }

    public function nouveauTransfert(Request $request){
        if(isset($request["depot_depart"])){
            // comptable
            $depot = Depot::where("nom_depot",$request["depot_depart"])->first();
            $mvts = $this->stock->newMvtTransf($depot->id, $request["marchs"], $request["depot_destination"]);
        }else{
            // magasinier
            $employee_depot = $request->session()->get('depot_name');
            $depot = Depot::where("nom_depot",$employee_depot)->first();
            
            $mvts = $this->stock->newMvtTransf($depot->id, $request["marchs"], $request["depot_destination"]);
            // return redirect('transfertStock');
        }
        return response()->json(['res' => "ok"]);
    }

    public function getDetailsMouvts(Request $request){
        $articles = $this->stock->detailsMouvement(1, $request["code"]);
        return response()->json($articles);
    }


}
