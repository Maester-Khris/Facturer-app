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
Route::get('/nouvellesEntites', 'App\Http\Controllers\Administration\NewEntitiesController@index');
Route::post('/enregistrer-depot', 'App\Http\Controllers\Administration\NewEntitiesController@savedepot');
Route::post('/enregistrer-marchandise', 'App\Http\Controllers\Administration\NewEntitiesController@savemarchandise');
Route::post('/enregistrer-caisse', 'App\Http\Controllers\Administration\NewEntitiesController@savecaisse');
Route::post('/enregistrer-comptoir', 'App\Http\Controllers\Administration\NewEntitiesController@savecomptoir');
Route::post('/enregistrer-personnel', 'App\Http\Controllers\Administration\NewEntitiesController@savepersonnel');


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
Route::get('/listeinventaire', 'App\Http\Controllers\Stock\InventaireController@listinventaire');

Route::get('/inventaire','App\Http\Controllers\Stock\InventaireController@index');
Route::get('/etatinventaire','App\Http\Controllers\Stock\EtatInventaireController@index');
Route::get('/transfer-error', 'App\Http\Controllers\Stock\SituationdepotController@indexwitherror');

Route::post('/fiche-marchandise', 'App\Http\Controllers\Stock\ArticleController@voirmarchandise');
Route::post('/details-mvt', 'App\Http\Controllers\Stock\MouvementController@getDetailsMouvts');
Route::post('/details-ivt', 'App\Http\Controllers\Stock\InventaireController@getDetailsIvts');
Route::post('/entree-stock', 'App\Http\Controllers\Stock\MouvementController@nouvelleEntree');
Route::post('/sortie-stock', 'App\Http\Controllers\Stock\MouvementController@nouvelleSortie');
Route::post('/transfert-stock', 'App\Http\Controllers\Stock\MouvementController@nouveauTransfert');
Route::post('/reajuster-march', 'App\Http\Controllers\Stock\SituationdepotController@reajustMarchStock');
Route::post('/transferer-march', 'App\Http\Controllers\Stock\SituationdepotController@transferMarch');
Route::post('/saisie-inv', 'App\Http\Controllers\Stock\InventaireController@newSaisie');
Route::post('/newetat-inv', 'App\Http\Controllers\Stock\EtatInventaireController@nouvelEtat');

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
//                 STATISTIQUE
// =============== ************** ================================
Route::get('/statArticle', 'App\Http\Controllers\Statistique\StatArticleController@index');

// =============== ************** ================================
//                  REDIRECT HOME
// =============== ************** ================================
Route::get('/', function () {
    return redirect('/interrogerArticles');
});


// =============== ************** ================================
//                  UTILITY ROUTE
// =============== ************** ================================
Route::post('autocomplete', 'App\Http\Controllers\UtilityController@suggestproduct'); 
Route::post('autocomplete-client', 'App\Http\Controllers\UtilityController@suggestclient'); 
Route::post('stockinfo', 'App\Http\Controllers\UtilityController@stockmarchandiseinfo'); 