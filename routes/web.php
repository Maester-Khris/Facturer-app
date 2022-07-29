<?php

use Illuminate\Support\Facades\Route;


// Route::get('test', 'App\Http\Controllers\Stock\ArticleController@voirmarchandise');
Route::get('test', 'App\Http\Controllers\TestController@index');


// =============== ************** ================================
//                  ADMINISTRATION
// =============== ************** ================================
Route::get('/nouvellesEntites', 'App\Http\Controllers\Administration\NewEntitiesController@index');
Route::post('/enregistrer-depot', 'App\Http\Controllers\Administration\NewEntitiesController@savedepot');
Route::post('/enregistrer-marchandise', 'App\Http\Controllers\Administration\NewEntitiesController@savemarchandise');
Route::post('/enregistrer-caisse', 'App\Http\Controllers\Administration\NewEntitiesController@savecaisse');
Route::post('/enregistrer-comptoir', 'App\Http\Controllers\Administration\NewEntitiesController@savecomptoir');
Route::post('/enregistrer-client', 'App\Http\Controllers\Administration\NewEntitiesController@saveclient');
Route::post('/enregistrer-fournisseur', 'App\Http\Controllers\Administration\NewEntitiesController@savefournisseur');
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
Route::get('/transfertStock', 'App\Http\Controllers\Stock\MouvementController@transfert');
Route::get('/mouvementsStock', 'App\Http\Controllers\Stock\MouvementController@index');
Route::get('/listeinventaire', 'App\Http\Controllers\Stock\InventaireController@listinventaire');
Route::get('/inventaire','App\Http\Controllers\Stock\InventaireController@index');
Route::get('/etatinventaire','App\Http\Controllers\Stock\EtatInventaireController@index');
Route::get('/transfer-error', 'App\Http\Controllers\Stock\SituationdepotController@indexwitherror');
Route::post('stockinfo', 'App\Http\Controllers\UtilityController@stockmarchandiseinfo'); 

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
//                  VENTE 
// =============== ************** ================================
Route::get('/nouvelleFactureVente', 'App\Http\Controllers\Vente\NouvellefactureController@index');
Route::get('/listeFacturesClient','App\Http\Controllers\Vente\ListefactureController@index');
Route::get('/interrogerCompteClient', 'App\Http\Controllers\Vente\CompteclientController@index');
Route::get('/reglementFactureVente', 'App\Http\Controllers\Vente\ReglementfactureController@index');

Route::post('/ligne-facture-vente', 'App\Http\Controllers\Vente\NouvellefactureController@addmarchandise');
Route::post('/enregistrer-facturevente', 'App\Http\Controllers\Vente\NouvellefactureController@savefacture');
Route::post('/client-activities', 'App\Http\Controllers\Vente\CompteclientController@activities');
Route::post('/regler-facture-vente', 'App\Http\Controllers\Vente\ReglementfactureController@soldvente');


// =============== ************** ================================
//                  VEMTE COMPTOIR & CAISSE
// =============== ************** ================================
Route::get('/ventesComptoir', 'App\Http\Controllers\Comptoir\VenteComptoirController@index')->middleware('ventecomptoir');
Route::post('/enregistrer-ticketencours', 'App\Http\Controllers\Comptoir\VenteComptoirController@saveTicketEnCours');
Route::post('/enregistrer-ticketenattente', 'App\Http\Controllers\Comptoir\VenteComptoirController@saveTicketEnAttente');
Route::get('/rappel-ticketenattente', 'App\Http\Controllers\Comptoir\VenteComptoirController@rappelTicketEnAttente'); 
Route::post('/nouveau-codeticket', 'App\Http\Controllers\Comptoir\VenteComptoirController@newCodeTicket'); 

Route::get('/operationCaisse', 'App\Http\Controllers\Comptoir\CaisseController@index')->middleware('ventecomptoir');;
Route::post('/caisse-statut', 'App\Http\Controllers\Comptoir\CaisseController@getStatut'); 
Route::post('/toggleEtatCaisse', 'App\Http\Controllers\Comptoir\CaisseController@toggleStatut'); 
Route::post('/interrogerCaisse', 'App\Http\Controllers\Comptoir\CaisseController@interrogerCaisse');
Route::post('/details-ticket', 'App\Http\Controllers\Comptoir\CaisseController@getDetailTicket');
Route::get('/ouvrir-caisse', 'App\Http\Controllers\Comptoir\CaisseController@openCaisse')->middleware('ventecomptoir');
Route::get('/fermer-caisse', 'App\Http\Controllers\Comptoir\CaisseController@closeCaisse')->middleware('ventecomptoir');

// =============== ************** ================================
//                 STATISTIQUE
// =============== ************** ================================

Route::get('/statGenerale', 'App\Http\Controllers\Statistique\StatArticleController@index');
Route::post('/statDepot', 'App\Http\Controllers\Statistique\StatArticleController@getStatDepot');

// =============== ************** ================================
//                  REDIRECT HOME
// =============== ************** ================================
Route::get('/', function () {
    return redirect('/nouvellesEntites');
});


// =============== ************** ================================
//                  UTILITY ROUTE
// =============== ************** ================================
Route::post('autocomplete', 'App\Http\Controllers\UtilityController@suggestproduct'); 
Route::post('autocomplete-comptoir', 'App\Http\Controllers\UtilityController@suggestproductForComptoir'); 
Route::post('autocomplete-client', 'App\Http\Controllers\UtilityController@suggestclient'); 
Route::get('connexion', 'App\Http\Controllers\UserController@connexion'); 
Route::post('connect', 'App\Http\Controllers\UserController@connect'); 
Route::get('deconnect', 'App\Http\Controllers\UserController@deconnect'); 