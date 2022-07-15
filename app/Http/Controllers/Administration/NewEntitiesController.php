<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Depot;
use App\Models\Caisse;
use App\Models\Comptoir;
use App\Models\Personnel;
use App\Models\Marchandise;
use Validator;

class NewEntitiesController extends Controller
{
    public function index(){
        $depots = Depot::all();
        $caisses = Caisse::all();
        $personnels = Personnel::all();
        return view('administration.nouvellesEntites')
        ->with(compact('depots'))
        ->with(compact('caisses'))
        ->with(compact('personnels'));
    }

    public function savedepot(Request $request){
        $validator = Validator::make($request->all(),[
            'nom_depot' => 'required',
            'telephone' => 'required',
            'delai_reglement' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }

        Depot::create($request->all());
        return redirect('/nouvellesEntites');
    }

    public function savecaisse(Request $request){
        $validator = Validator::make($request->all(),[
            'libelle' => 'required',
            'numero_caisse' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }

        Caisse::create($request->all());
        return redirect('/nouvellesEntites');
    }

    public function savecomptoir(Request $request){
        $validator = Validator::make($request->all(),[
            'libelle' => 'required',
            'caisse_id' => 'required',
            'personnel_id' => 'required',
            'depot_id' => 'required',
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }

        Comptoir::create($request->all());
        return redirect('/nouvellesEntites');
    }

    public function savepersonnel(Request $request){
        $validator = Validator::make($request->all(),[
            'nom_complet' => 'required',
            'sexe' => 'required',
            'telephone' => 'required',
            'email' => 'required',
            'cni' => 'required',
            'matricule' => 'required',
            'matricule_cnps' => 'required',
            'date_embauche' => 'required',
            'type_contrat' => 'required',
            'poste' => 'required',
            'depot_id' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }

        Personnel::create($request->all());
        return redirect('/nouvellesEntites');
    }

    public function savemarchandise(Request $request){
        $validator = Validator::make($request->all(),[
            'reference' => 'required',
            'designation' => 'required',
            'prix_achat' => 'required',
            'prix_vente_detail' => 'required',
            'prix_vente_gros' => 'required',
            'prix_vente_super_gros' => 'required',
            'unite_achat' => 'required',
            'conditionement' => 'required',
            'quantité_conditionement' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }

        Marchandise::create($request->all());
        return redirect('/nouvellesEntites');
    }
}
