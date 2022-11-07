<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Marchandise;
use App\Models\Compte;
use App\Models\Personnel;
use App\Models\Depot;
use App\Models\User;
use App\Models\Client;
use App\Models\Caisse;
use App\Models\Comptoir;
use App\Models\Fournisseur;

class ModifierEntiteController extends Controller
{

    private $model_namespace = "Illuminate\Database\Eloquent\Model";

    // get element - open the view with the type and the object to modify - insert it in the form
    public function index(Request $request){
        $type_entite = $request->type_model;
        if($type_entite == "depot"){
            $object = Depot::where("nom_depot",$request->data)->first();
        }elseif($type_entite == "marchandise"){
            $object = Marchandise::getMarchByRef($request->data);
        }elseif($type_entite == "client"){
            $object = Client::getClient($request->data,$request->depotid);
        }elseif($type_entite == "fournisseur"){
            $object = Fournisseur::getFournisseur($request->depotid, $request->data,);
        }elseif($type_entite == "personnel"){
            $object = Personnel::getEmployeeByMatricule($request->data);
        }
        // dd($object);
        if($object){
            return view('administration.modifierEntite')->with(compact('type_entite'))->with(compact('object'));
        }else{
            $update_error = "Objet introuvable";
            return back()->with('update_error_entite', $update_error);
        }
        
    }

    public function updateDepot(Request $request){
        $old_depot = Depot::find($request->id);
        $old_depot->nom_depot = $request->nom_depot;
        $old_depot->telephone = $request->telephone;
        $old_depot->delai_reglement = $request->delai_reglement;
        $old_depot->save();
        return redirect('/listeEntites');
    }
    public function updateMarchandise(Request $request){
        $old_march = Marchandise::find($request->id);
        $old_march->designation = $request->designation;
        $old_march->prix_achat = $request->prix_achat;
        $old_march->prix_vente_detail = $request->prix_vente_detail;
        $old_march->prix_vente_gros = $request->prix_vente_gros;
        $old_march->prix_vente_super_gros = $request->prix_vente_super_gros;
        $old_march->unite_achat = $request->unite_achat;
        $old_march->conditionement = $request->conditionement;
        $old_march->quantité_conditionement = $request->quantité_conditionement;
        $old_march->save();
        return redirect('/listeEntites');
    }
    public function updateClient(Request $request){
        $old_client = Client::find($request->id);
        $old_client->nom_complet = $request->nom;
        $old_client->telephone = $request->telephone;
        $old_client->tarification_client = $request->tarification;
        $old_client->save();
        return redirect('/listeEntites');
    }
    public function updateFournisseur(Request $request){
        $old_founi = Fournisseur::find($request->id);
        $old_founi->nom_complet = $request->nom;
        $old_founi->telephone = $request->telephone;
        $old_founi->type_fournisseur = $request->type_fournisseur;
        $old_founi->save();
        return redirect('/listeEntites');
    }

    public function updatePersonnel(Request $request){
        $old_employee = Personnel::find($request->id);
        $old_employee->nom_complet = $request->nom_complet;
        $old_employee->telephone = $request->telephone;
        $old_employee->email = $request->email;
        $old_employee->cni = $request->cni;
        $old_employee->date_embauche = $request->date_embauche;
        $old_employee->matricule = $request->matricule;
        $old_employee->matricule_cnps = $request->matricule_cnps;
        $old_employee->save();
        return redirect('/listeEntites');
    }
}
