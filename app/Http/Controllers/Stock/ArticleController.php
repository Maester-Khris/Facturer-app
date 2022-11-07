<?php

namespace App\Http\Controllers\Stock;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use \stdClass;
use App\Models\Depot;
use App\Models\Stockdepot;
use App\Models\Inventaire;
use App\Models\Marchandise;
use App\Models\Mouvementstock;
use App\Services\StockService;


class ArticleController extends Controller
{
   private $stock;
   public function __construct(StockService $stock){
      $this->stock = $stock;
   }

   public function index(){
      $depots = Depot::all();
      return view('stock.interrogerArticles')->with(compact('depots'));
   }

   public function listMarchandise(Request $request){
      $depots = Depot::all();
      $articles = $this->stock->stockArticlesList($request->depot);
      $selecteddepot = $request->depot;
      return view('stock.interrogerArticles')->with(compact('depots'))->with(compact('articles'))->with(compact('selecteddepot'));
   }

   public function voirmarchandise(Request $request){
      $marchandise = $this->stock->marchandiseDetails($request->reference);
      return response()->json(['success'=> $marchandise]);
   }

   public function getdetailsStockMarch(Request $request){
      $label = "mouvementstocks.";
      $marchid = Marchandise::getMarchIdByRef($request->reference);
      $depot = Depot::getDepotById($request->depot);

      $mouvements = Mouvementstock::join('stockdepots','mouvementstocks.stockdepot_id','=','stockdepots.id')
      ->join('marchandises','mouvementstocks.marchandise_id','=','marchandises.id')
      ->where('stockdepots.marchandise_id',$marchid)
      ->where('stockdepots.depot_id',$request->depot)
      ->select($label.'reference_mouvement',$label.'type_mouvement',$label.'quantite_mouvement',$label.'date_operation','marchandises.designation')
      ->get();

      $label = "inventaires.";
      $inventaires = Inventaire::join('stockdepots','inventaires.stockdepot_id','=','stockdepots.id')
      ->join('marchandises','inventaires.marchandise_id','=','marchandises.id')
      ->where('stockdepots.marchandise_id',$marchid)
      ->where('stockdepots.depot_id',$request->depot)
      ->select($label.'reference_inventaire',$label.'difference',$label.'date_reajustement','marchandises.designation')
      ->get();

      $res1 = $this->formatDetailStock($mouvements, $depot->nom_depot, true);
      $res2 = $this->formatDetailStock($inventaires, $depot->nom_depot, false);
      $final = $res1->merge($res2);
      // dd($final);


      $actual_stock = Stockdepot::where('stockdepots.marchandise_id',$marchid)
      ->where('stockdepots.depot_id',$request->depot)
      ->select('quantite_stock')
      ->first();

      return [$final, $actual_stock->quantite_stock];
   }

   public function formatDetailStock($datas, $depot_name, $is_mvt){
      $res = collect();
     
      if($is_mvt == true){
         foreach($datas as $data){
            $ligne = new \stdClass();
            $ligne->des_marchandise = $data->designation;
            $ligne->depot_operation = $depot_name;
            $ligne->reference_mouvement = $data->reference_mouvement;
            $ligne->type_mouvement = $data->type_mouvement;
            $ligne->quantite_mouvement = $data->quantite_mouvement;
            $ligne->date_operation = $data->date_operation;
            $res->push($ligne);
         }
      }else{
         foreach($datas as $data){
            $ligne = new \stdClass();
            $ligne->des_marchandise = $data->designation;
            $ligne->depot_operation = $depot_name;
            $ligne->reference_mouvement = $data->reference_inventaire;
            $ligne->type_mouvement = $data->difference < 0 ? "Sortie" : "Entrée";
            $ligne->quantite_mouvement = $data->difference;
            $ligne->date_operation = $data->date_reajustement;
            $res->push($ligne);
         }
      }
      return $res;
   }
}

