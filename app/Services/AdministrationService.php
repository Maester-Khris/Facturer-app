<?php
namespace App\Services;

use App\Models\Depot;
use App\Models\Comptoir;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Personnel;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DateTime;

class AdministrationService{

      public static function associatePersonelToDepot($matricule_perso, $depotid){
            $employee = Personnel::getEmployeeByMatricule($matricule_perso);
            $depot = Depot::find($depotid);
            $depot->personnels()->save($employee);
      }
      public static function associateComptoirToPersonnel($comptoir_libelle, $perso_id){
            $employee = Personnel::find($perso_id);
            $comptoir = Comptoir::getComptoirByLibelle($comptoir_libelle, $employee->depot->id);
            $employee->comptoir()->save($comptoir);
      }

      public static function newFournisseur($data){
            $fournisseur = Fournisseur::create([
                  "nom_complet" => $data->nom,
                  "telephone" => $data->telephone,
                  "type_fournisseur" => $data->type_fournisseur
            ]);
            $depot = Depot::find($data->depot_id);
            $depot->fournisseurs()->save($fournisseur);
      }
      public static function newClient($data){
            $client = Client::create([
                  "nom_complet" => $data->nom,
                  "telephone" => $data->telephone,
                  "tarification_client" => $data->tarification
            ]);
            $depot = Depot::find($data->depot_id);
            $depot->clients()->save($client);
      }

      public static function createEmployeeUser($employee, $name, $email, $matricule){
            $user = User::create([
                  'name' => $name,
                  'email' => $email,
                  'password' => Hash::make($matricule),
            ]);
            $employee->user_id = $user->id;
            $employee->save();
            return $user;
      }

      public static function giveEmployeeUserPermission($user, $poste){
            if($poste == "vendeur"){
                  $role = Role::find(1);
            }
            else if($poste == "magasinier"){
                  $role = Role::find(2);
            }
            else if($poste == "chef_equipe"){
                  $role = Role::find(3);
            }
            else if($poste == "comptable"){
                  $role = Role::find(4);
            }
            $user->assignRole($role);
      }

      /**
       * Condition actuel
       * on a un seul personnel, une caisse et un comptoir, un seul depot
      */

      /**
       * Plan des compte: 
       *    Classification des comtes géré et fonctions de ceux-ci : 
       *    Clients, fournisseurs, charge personnel
      */

      /**
       * Balance des compte: 
       * on ne gere que 03 comptes
       * pour avoir une bilan mensuel on affiche par mois
       * pour chaque on affiche: 
       * le nimero de compte, le nom du proprietaire, le total des debit, le total des credit, le solde 
       * ensuite le total de tout les soldes
      */

      /**
       * Suivi des activites: 
       * bilan mensuel
       * on affiche: les ventes
       *    trie par date, client/non, reference ticket, total, entierement payé ou non, comptoir qui a enregistré
      */


}