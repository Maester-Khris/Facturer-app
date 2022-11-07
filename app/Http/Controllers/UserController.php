<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function connexion(){
        return view('connexion');
    }
    public function connect(Request $request){
        $validator = Validator::make($request->all(), [
            'nom' => ['required'],
            'matricule' => ['required'],
        ]);
        if ($validator->fails()) {
            $connexion_error = "Formulaire mal remplie";
            return back()->with('error_login',$connexion_error);
        }

        $employe = Personnel::where('nom_complet',$request->nom)->where('matricule',$request->matricule)->first();
        $user_exist = User::where('name', $employe->nom_complet)->first();
        if($user_exist == null){
            $connexion_error = "Utilisateur non reconnu, verifier les identifiants";
            return back()->with('error_login',$connexion_error);
        }else{
            $user = $employe->user;
            session()->put('personnel_id', $employe->id);
            session()->put('depot_name', $employe->depot->nom_depot);

            if($request->remember == "yes"){
                Auth::login($user, $remember = true);
            }else{
                Auth::login($user);
            }
            $request->session()->regenerate();
            $user->statut = true;
            $user->save();

            if($user->hasAnyRole(["vendeur","chef_equipe"])){
                return redirect('/ventesComptoir');
            }else if($user->hasRole("magasinier")){
                return redirect('/transfertStock');
            }else if($user->hasRole("comptable")){
                return redirect('/');
            }
        }
    }

    public function deconnect(Request $request){
        $user = Auth::user();
        if($user){
            $user->statut = false;
            $user->save();
        }

        $request->session()->flush();
        Auth::logout();
        return redirect('/connexion');
    }

}
