<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;

use Validator;
use App\Models\User;
use App\Models\Personnel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

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
            if($request->remember == "yes"){
                session()->put('personnel_id', $employe->id);
                session()->put('depot_name', $employe->depot->nom_depot);
                Auth::login($user, $remember = true);
                $request->session()->regenerate();
                // mettre l'id du personnel et le nom de son depot en session
                
            }else{
                session()->put('personnel_id', $employe->id);
                session()->put('depot_name', $employe->depot->nom_depot);
                Auth::login($user);
                $request->session()->regenerate();
                
                // mettre l'id du personnel et le nom de son depot en session
            }
            return redirect('/ventesComptoir');
        }
    }

    public function deconnect(Request $request){
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
