<?php

namespace App\Http\Controllers\Stock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockService;
use App\Models\Mouvementstock;
use App\Services\DataService;
use App\Models\Depot;

class MouvementController extends Controller
{
    private $stock;
    public function __construct(StockService $stock){
        $this->stock = $stock;
    }

    public function index(Request $request){
        $depots = Depot::all();
        // $mvts = Mouvementstock::all();
        $mvts = Mouvementstock::allMouvement();
        return view('stock.mouvementsStock')->with(compact('depots'))->with(compact('mvts'));
    }

    // afficher la vue transfert pour magasinier
    public function transfert(Request $request){
        $employee_depot = $request->session()->get('depot_name');
        $depot = Depot::where('nom_depot', $employee_depot)->first();
        $transfertmvts = $this->stock->allTransferts($depot->id);
        $othersdepots = Depot::where('nom_depot','!=' , $employee_depot)->get();
        return view('stock.transfertsStock')->with(compact('transfertmvts'))->with(compact('othersdepots'));
   }

    public function mouvementOperations(Request $request){
        $mvts = $this->stock->allMouvements($request->depot);
        $depots = Depot::all();
        $selecteddepot = $request->depot;
        return view('stock.mouvementsStock')->with(compact('depots'))->with(compact('mvts'))->with(compact('selecteddepot'));;
    }

   
    public function nouvelleEntree(Request $request){
        $depot = Depot::where("nom_depot",$request["depot"])->first();
        if($depot){
            // $nbmvts = DataService::countMvtPerDepot($depot->id);
            $nbmvts = Mouvementstock::getAllMouvements();
            $ref_mov = DataService::genCode("MvtE", $nbmvts + 1);
            $mvts = $this->stock->newMvtEntreeSortie($depot->id, $ref_mov, $request["marchs"], "Entrée");
            return response()->json(["res" => "Succeed"], 200);
        }
        return response()->json(["res" => "error"], 401);
    }

    public function nouvelleSortie(Request $request){
        $depot = Depot::where("nom_depot",$request["depot"])->first();
        if($depot){
            // $nbmvts = DataService::countMvtPerDepot($depot->id);
            $nbmvts = Mouvementstock::getAllMouvements();
            $ref_mov = DataService::genCode("MvtS", $nbmvts + 1);
            $mvts = $this->stock->newMvtEntreeSortie($depot->id, $ref_mov, $request["marchs"], "Sortie");
            return response()->json(["res" => "succeed"], 200);
        }
        return response()->json(["res" => "error"], 401);
    }

    public function nouveauTransfert(Request $request){
        if($request["depot_depart"] != "default"){       // comptable
            $depot = Depot::where("nom_depot",$request["depot_depart"])->first();
            if($depot){
                // $nbmvts = DataService::countMvtPerDepot($depot->id);
                $nbmvts = Mouvementstock::getAllMouvements();
                $ref_mov = DataService::genCode("MvtT", $nbmvts + 1);
                $mvts = $this->stock->newMvtTransf($depot->id, $ref_mov, $request["marchs"], $request["depot_destination"]);
            }
        }else{   // magasinier
            $employee_depot = $request->session()->get('depot_name');
            $depot = Depot::where("nom_depot",$employee_depot)->first();
            // $nbmvts = DataService::countMvtPerDepot($depot->id);
            $nbmvts = Mouvementstock::getAllMouvements();
            $ref_mov = DataService::genCode("MvtT", $nbmvts + 1);
            $mvts = $this->stock->newMvtTransf($depot->id, $ref_mov, $request["marchs"], $request["depot_destination"]);
        }
        return response()->json(['res' => "ok"]);
    }

    public function getDetailsMouvts(Request $request){
        $articles = $this->stock->detailsMouvement($request["code"]);
        return response()->json($articles);
    }


}
