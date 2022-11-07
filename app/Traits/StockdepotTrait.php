<?php

namespace App\Traits;
use App\Models\Stockdepot;
use App\Models\Marchandise;
use Illuminate\Support\Facades\DB;

trait StockdepotTrait {

      public function marchandiseStockInfo($marchandiseid, $id_depot){
            $stock_march = Stockdepot::where('depot_id',$id_depot)->where("marchandise_id",$marchandiseid)->first();
            return $stock_march;
         }
      
      public function marchandiseQuantityStock($marchandise){
         $stock_march = Stockdepot::where("marchandise_id",$marchandise)->select('quantite_stock')->first();
         return $stock_march->quantite_stock;
      }

      public static function checkStockMarchDispoByDesign($iddepot, $designation, $quantite){
            $idmarch = Marchandise::getMarchId($designation);
            $march = Stockdepot::where('marchandise_id', $idmarch)
                  ->where('depot_id','>=',$iddepot)
                  ->where('quantite_stock','>=',$quantite)
                  ->first();
            return  $march;
      }
      public static function checkStockMarchFullByDesign($designation){
            $idmarch = Marchandise::getMarchId($designation);
            $march = Stockdepot::where('marchandise_id', $idmarch)
                  ->first();
            
            return  $march->quantite_stock == $march->quantite_optimal ? true : false;
      }

      public static function getAllStockArticles($id_depot){
            
            $articles = Stockdepot::where("depot_id",$id_depot)
                  ->join("marchandises","marchandises.id","=","stockdepots.marchandise_id")
                  ->select("stockdepots.quantite_stock","stockdepots.quantite_optimal","stockdepots.limite","marchandises.reference","marchandises.designation")
                  ->get();
            // dd($articles);
            return $articles;
      }

      public static function getSituationDepot($id_depot){
            // on get la liste des articles du depots.
            // pour chaque article: on affiche la reference, la designation,
            // la qté en stock, la der qte deplace, date der maj, der type operation

            $articles = DB::table("stockdepots")
                  ->get();

            $result = DB::select("
                  SELECT stockdepots.marchandise_id, stockdepots.quantite_stock, stockdepots.date_derniere_modif_qté, Last_update.quantite_mouvement, Last_update.type_mouvement
                  FROM stockdepots
                  LEFT JOIN 
                  (SELECT * FROM mouvementstocks
                  INNER JOIN (
                        SELECT marchandise_id as marchandise, MAX(date_operation) as date_mouv FROM mouvementstocks
                  GROUP BY marchandise_id
                  )Latestmarchandise
                  ON Latestmarchandise.marchandise = mouvementstocks.marchandise_id
                  AND Latestmarchandise.date_mouv = mouvementstocks.date_operation
                  ORDER BY mouvementstocks.marchandise_id) as Last_update
                  ON stockdepots.marchandise_id = Last_update.marchandise_id;
            ");
            // dd($result);

            $articles = collect();
            foreach($result as $article){
                  $march = Marchandise::getMarchById($article->marchandise_id);
                  $ligne = [
                        'reference'  =>  $march->reference,            
                        'designation'  => $march->designation,
                        'quantite_stock'  => $article->quantite_stock,
                        'der_qte_mouvement'  => $article->quantite_mouvement,
                        'date_der_mouvement'  => $article->date_derniere_modif_qté,
                        'type_mouvement'  => $article->type_mouvement,
                  ];
                  if(!is_null($article->date_derniere_modif_qté)){
                        $articles->push($ligne);
                  }
            }
           return $articles;
      }
}
