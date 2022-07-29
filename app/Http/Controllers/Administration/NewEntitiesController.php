<?php

namespace App\Http\Controllers\Administration;


use \stdClass;
use Validator;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
// use App\Models\User;
use App\Models\Depot;
use App\Models\Caisse;
use App\Models\Comptoir;
use App\Models\Personnel;
use App\Models\Marchandise;
use App\Services\DataService;
use App\Services\StockService;
use App\Services\AdministrationService;



class NewEntitiesController extends Controller
{
    public function index(){
        $depots = Depot::all();
        $caisses = Caisse::all();
        $personnels = Personnel::all();
        $nbrowsmarch = Marchandise::all()->count();
        $ref_march = DataService::genCode("Marchandise", $nbrowsmarch + 1);
        $code_caisse =  DataService::genCode("Caisse", $caisses->count() + 1);
        $matricule_personnel =  DataService::genCode("Personnel", $personnels->count() + 1);

        return view('administration.nouvellesEntites')
        ->with(compact('depots'))->with(compact('caisses'))->with(compact('personnels'))
        ->with(compact('ref_march'))->with(compact('code_caisse'))->with(compact('matricule_personnel'));
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

        $comptoir = Comptoir::create($request->all());
        AdministrationService::associateComptoirToPersonnel($request->libelle, $request->personnel_id);
        $data = new \stdClass();
        $data->nom = 'Clt '.$request->libelle;
        $data->telephone = 'telephone comptoir';
        $data->tarification = 'detail';
        $data->depot_id = $comptoir->personnel->depot->id;
        AdministrationService::newClient($data);

        return redirect('/nouvellesEntites');
    }

    public function savepersonnel(Request $request){
        $validator = Validator::make($request->all(),[
            'nom_complet' => 'required','sexe' => 'required', 'telephone' => 'required',
            'email' => 'required', 'cni' => 'required','matricule' => 'required',
            'matricule_cnps' => 'required','date_embauche' => 'required','type_contrat' => 'required',
            'poste' => 'required','depot_id' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }
        Personnel::create($request->all());
        $personnel = Personnel::where('matricule',$request->matricule)->first();

        // create his user account
        $user = AdministrationService::createEmployeeUser($personnel, $request->nom_complet, $request->email, $request->matricule);
        
        // get role and permission to this person
        AdministrationService::giveEmployeeUserPermission($user, $request->poste);

        // register his depot
        AdministrationService::associatePersonelToDepot($request->matricule, $request->depot_id);
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

        $march = Marchandise::create($request->all());
        StockService::addMarchandiseInAllStock($march->id);
        return redirect('/nouvellesEntites');
    }

    public function saveclient(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required',
            'telephone' => 'required',
            'tarification' => 'required',
            'depot_id' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }
        $data = (object) $request->input();
        AdministrationService::newClient($data);
        return redirect('/nouvellesEntites');
    }

    public function savefournisseur(Request $request){
        $validator = Validator::make($request->all(),[
            'nom' => 'required',
            'telephone' => 'required',
            'type_fournisseur' => 'required',
            'depot_id' => 'required'
        ]);
        if ($validator->fails()) {
            $transf_error = "Formulaire mal remplie";
            return back()->with('error_form_entite',$transf_error);
        }
        $data = (object) $request->input();
        AdministrationService::newFournisseur($data);
        return redirect('/nouvellesEntites');
    }
}

// $user = User::create([
        //     'name' => $request->nom_complet,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->matricule),
        // ]);
        // $personnel->user_id = $user->id;
        // $personnel->save();
