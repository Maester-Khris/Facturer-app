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
            // on get les liste des articles du depots.
            // pour chaque article: on affiche la reference, la designation,
            // la qté en stock, la der qte deplace, date der maj, der type operation
            $articles = Stockdepot::where("depot_id",$id_depot)
                  ->whereNotNull("date_derniere_modif_qté")
                  ->join("marchandises","marchandises.id","=","stockdepots.id")
                  ->join("mouvementstocks","mouvementstocks.marchandise_id","=","stockdepots.marchandise_id")
                  // ->where("stockdepots.date_derniere_modif_qté","=","mouvementstocks.date_operation")
                  ->select("stockdepots.quantite_stock","stockdepots.date_derniere_modif_qté","mouvementstocks.type_mouvement","mouvementstocks.quantite_mouvement","marchandises.reference","marchandises.designation")
                  ->get();

            return $articles;
      }
}
