<?php
namespace App\Services;

use App\Models\Depot;
use App\Models\Comptoir;
use App\Models\Caisse;
use App\Models\Client;
use App\Models\Fournisseur;
use App\Models\Personnel;
use App\Models\Compte;

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
      public static function newCompte($numero, $intitule, $type="tiers"){
            $compte = new Compte;
            $compte->numero_compte = $numero;
            $compte->intitule = $intitule;
            $compte->type = isset($type) ? $type : "tiers";
            $compte->save();
      }

      public static function newCaisse($data){
            $caisse = Caisse::create([
                  "depot_id" => $data->depot_id,
                  "libelle" => $data->libelle,
                  "numero_caisse" => $data->numero_caisse,
            ]);
            // $nbcaisse = DataService::countCaissePerDepot($data->depot_id);
            $nbcaisse = Caisse::count();
            $numcompte = DataService::genCode('CompteCAI', $nbcaisse);
            AdministrationService::newCompte($numcompte, $caisse->libelle, "tresorerie");
      }
      public static function newFournisseur($data){
            $fournisseur = Fournisseur::create([
                  "nom_complet" => $data->nom,
                  "telephone" => $data->telephone,
                  "type_fournisseur" => $data->type_fournisseur
            ]);
            $depot = Depot::find($data->depot_id);
            $depot->fournisseurs()->save($fournisseur);
            // $nbfournisseur = DataService::countFournisseurPerDepot($data->depot_id);
            $nbfournisseur = Fournisseur::count();
            $numcompte = DataService::genCode('CompteF', $nbfournisseur );
            AdministrationService::newCompte($numcompte, $fournisseur->nom_complet);
      }
      public static function newClient($data){
            $client = Client::create([
                  "nom_complet" => $data->nom,
                  "telephone" => $data->telephone,
                  "tarification_client" => $data->tarification
            ]);
            $depot = Depot::find($data->depot_id);
            $depot->clients()->save($client);
            // $nbclients = DataService::countClientPerDepot($data->depot_id);
            $nbclients = Client::count();
            $numcompte = DataService::genCode('CompteCLT', $nbclients);
            AdministrationService::newCompte($numcompte, $client->nom_complet);
      }
      public static function newCompteMarchandise($march){
            $nbmarchs = DataService::countAllMarchs();
            $numcompte1 = DataService::genCode('CompteMarchA', $nbmarchs);
            $numcompte2 = DataService::genCode('CompteMarchV', $nbmarchs);
            AdministrationService::newCompte($numcompte1, $march->designation, "gestion");
            AdministrationService::newCompte($numcompte2, $march->designation, "gestion");
      }
      public static function newAutreTypeCompte($data){
            $depot = Depot::getDepotById($data->depot_id);
            Compte::create([
                  "numero_compte" => $data->numero_compte,
                  "intitule" => $data->intitule . ' - ' . strtolower($depot->nom_depot),
                  "type" => $data->type_compte
            ]);
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