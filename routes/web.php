<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('test', 'App\Http\Controllers\Stock\ArticleController@voirmarchandise');

// =============== ************** ================================
//                  ADMINISTRATION
// =============== ************** ================================
Route::get('/nouvellesEntites', function () {
    return view('administration.nouvellesEntites');
});

Route::get('/descriptionSociete', function () {
    return view('administration.descriptionSociete');
});

Route::get('/balanceCompte', function () {
    return view('administration.balanceCompte');
});

Route::get('/planCompte', function () {
    return view('administration.planCompte');
});

Route::get('/suiviActivites', function () {
    return view('administration.suiviActivites');
});


// =============== ************** ================================
//                  STOCK
// =============== ************** ================================
Route::get('/interrogerArticles', 'App\Http\Controllers\Stock\ArticleController@index');
Route::get('/mouvementsStock', 'App\Http\Controllers\Stock\MouvementController@index');
Route::get('/situiationDepots', 'App\Http\Controllers\Stock\SituationdepotController@index');
Route::get('/inventaire','App\Http\Controllers\Stock\InventaireController@index');

Route::post('/fiche-marchandise', 'App\Http\Controllers\Stock\ArticleController@voirmarchandise');
Route::post('/reajuster-march', 'App\Http\Controllers\Stock\SituationdepotController@reajustMarchStock');
Route::post('/transferer-march', 'App\Http\Controllers\Stock\SituationdepotController@transferMarch');
Route::post('/ligne-inv', 'App\Http\Controllers\Stock\InventaireController@newLigne');

// =============== ************** ================================
//                    ACHTAT
// =============== ************** ================================
Route::get('/nouvelleFacture', function () {
    return view('achat.nouvelleFacture');
});

Route::get('/compteFournisseur', function () {
    return view('achat.interrogerCompteFournisseur');
});

Route::get('/facturesFournisseur', function () {
    return view('achat.facturesFournisseur');
});


// =============== ************** ================================
//                  VENTE & VENTE EN LIGNE
// =============== ************** ================================
Route::get('/nouvelleFactureVente', function () {
    return view('vente.nouvelleFactureVente');
});

Route::get('/interrogerCompteClient', function () {
    return view('vente.interrogerCompteClient');
});

Route::get('/listeFacturesClient', function () {
    return view('vente.listeFacturesClient');
});

Route::get('/ventesComptoir', function () {
    return view('ventesComptoir');
});


Route::get('/', function () {
    return redirect('/interrogerArticles');
});
