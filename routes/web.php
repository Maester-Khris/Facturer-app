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
//                     NOTES
// =============== ************** ================================
/*
*   Se rappeler de refactorer les routes et leur appels a la fin
    pour integrer les middleware, name et prefix
*/

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
Route::get('/nouvelleFacture', 'App\Http\Controllers\Achat\NouvellefactureController@index');
Route::get('/facturesFournisseur', 'App\Http\Controllers\Achat\ListefactureController@index');
Route::get('/compteFournisseur', 'App\Http\Controllers\Achat\ComptefournisseurController@index');
Route::get('/reglementFacture', 'App\Http\Controllers\Achat\ReglementFactureController@index');

Route::post('/ligne-facture', 'App\Http\Controllers\Achat\NouvellefactureController@addmarchandise');
Route::post('/enregistrer-factureachat', 'App\Http\Controllers\Achat\NouvellefactureController@savefacture');
Route::post('/fourni-activities', 'App\Http\Controllers\Achat\ComptefournisseurController@activities');
Route::post('/regler-facture', 'App\Http\Controllers\Achat\ReglementFactureController@soldbills');


// =============== ************** ================================
//                  VENTE & VENTE EN LIGNE
// =============== ************** ================================
Route::get('/nouvelleFactureVente', 'App\Http\Controllers\Vente\NouvellefactureController@index');
Route::get('/listeFacturesClient','App\Http\Controllers\Vente\ListefactureController@index');
Route::get('/interrogerCompteClient', 'App\Http\Controllers\Vente\CompteclientController@index');
Route::get('/reglementFactureVente', 'App\Http\Controllers\Vente\ReglementfactureController@index');

Route::post('/ligne-facture-vente', 'App\Http\Controllers\Vente\NouvellefactureController@addmarchandise');
Route::post('/enregistrer-facturevente', 'App\Http\Controllers\Vente\NouvellefactureController@savefacture');
Route::post('/client-activities', 'App\Http\Controllers\Vente\CompteclientController@activities');
Route::post('/regler-facture-vente', 'App\Http\Controllers\Vente\ReglementfactureController@soldvente');

Route::get('/ventesComptoir', function () {
    return view('ventesComptoir');
});

// =============== ************** ================================
//                  REDIRECT HOME
// =============== ************** ================================
Route::get('/', function () {
    return redirect('/interrogerArticles');
});


