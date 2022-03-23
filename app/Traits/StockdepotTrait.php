<?php

namespace App\Traits;
use App\Models\Stockdepot;

trait StockdepotTrait {

      public function marchandiseQuantityStock($marchandise){
         $stock_march = Stockdepot::where("marchandise_id",$marchandise)->select('quantite_stock')->first();
         return $stock_march->quantite_stock;
      }

      public static function getAllStockArticles($id_depot){
            $articles = Stockdepot::where("depot_id",$id_depot)
                  ->join("marchandises","marchandises.id","=","stockdepots.id")
                  ->select("stockdepots.quantite_stock","stockdepots.quantite_optimal","stockdepots.limite","marchandises.reference","marchandises.designation")
                  ->get();

            return $articles;
      }

      public static function getSituationDepot($id_depot){
            // on get la liste des articles du depots.
            // pour chaque article: on affiche la reference, la designation,
            // la qté en stock, la der qte deplace, date der maj, der type operation

            $articles = Stockdepot::with('marchandises')->where('depot_id',$id_depot)->get();
            foreach($articles as $article){
                  
            }
      }
}







// ->join(\DB::raw('
// SELECT * FROM mouvementstocks mv1 WHERE id = ( SELECT id FROM mouvementstocks mv2 WHERE date_operation = MAX(mv2.date_operation) )
// '), function($join){
// $join->on('stockdepots.marchandise_id','=','mouvementstocks.marchandise_id');
// })

// ->join("mouvementstocks","mouvementstocks.marchandise_id","=","stockdepots.marchandise_id")
// ->orderBy("mouvementstocks.date_operation","desc")
// ->limit(1)
// ->where("stockdepots.date_derniere_modif_qté","=","mouvementstocks.date_operation")

// ->join("mouvementstocks", function($join){
//       $join->on("mouvementstocks.marchandise_id","=","stockdepots.marchandise_id")
//       ->on("mouvementstocks.date_operation",\DB::raw(
//             'SELECT MAX(mouvementstocks.date_operation) FROM mouvementstocks'
//       ));
// })
// ->select("stockdepots.quantite_stock","stockdepots.date_derniere_modif_qté","mouvementstocks.type_mouvement","mouvementstocks.quantite_mouvement","marchandises.reference","marchandises.designation")
