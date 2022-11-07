<?php
namespace App\Services;


use App\Models\Vente;
use App\Models\Caisse;
use App\Models\Compte;
use App\Models\Client;
use App\Models\Ticket;
use App\Models\Stockdepot;
use App\Models\Marchandise;
use App\Models\Compteclient;
use App\Models\Comptecaisse;
use App\Models\Journalvente;
use App\Models\Detailcompte;
use App\Models\Mouvementstock;
use DateTime;

class VenteService{


      /**
       * journal vente contient id ticket, monant net remise et total
       * ticket ne comptient pas de de montant
       * ticket contient id marchandise, quantite, sur plusieur ligne date creation
       * ticket type de vente, indicatif ??
       * gerer le reglement de ticket passe toujours par compte caisse
      */

      /**
       * pour vendre: 
       * on enregistrer ticket
       * on ecrit dans le journal de ventes
       * credite le compte caisse (libele des operations)
       * si client on debite compte client
      */


      public function ListVente($id_depot){
           return Vente::getAllVentesByDepot($id_depot);
      }
      public static function getVenteByCode($codevente){
           return Vente::getByCode($codevente);
      }
      public function ListNonPaidVentes($id_depot){
           return Vente::unpaidVente($id_depot);
      }
      public function getClientSolde($client){
           return Client::retrieveSold($client);
      }
      public function allDepotVenteCount($id_depot){
            return Vente::countVentes($id_depot);
      }


      public function newVente($client_id,$codevente,$montants,$date){
            $vente = Vente::create([
                  'client_id' => $client_id,  
                  'code_vente' => $codevente, 
                  'montant_remise' => $montants[0], 
                  'montant_total' => $montants[1], 
                  'montant_net' => $montants[2], 
                  'indicatif' => 0,
                  'date_operation' => $date
            ]);
            return  $vente; 
      }

      /**
       * compte client fait un debit
       * return id compte client
      */
      public function updateComptaClient($client,$codeoperation,$montant_net,$today,$type){
            // $compte = Compteclient::create([
            //       'client_id' => $client->id,
            //       'debit' => ($type == "Débit") ? $montant_net : 0,
            //       'credit' => ($type == "Crédit") ? $montant_net : 0,
            //       'date_debit' => ($type == "Débit") ? $today : null,
            //       'date_credit' => ($type == "Crédit") ? $today : null,
            // ]);
            // // calcul du new solde fournisseur 
            // $this->updateSoldeClient($client);
            // return $compte->id;

            // ============= New Imple: ===============================
            $compte1 = Compte::where('intitule', $client->nom_complet)->first();
           
            $detail_vente = new Detailcompte;
            $detail_vente->numero_compte = $compte1->numero_compte;
            $detail_vente->reference_operation = "Facture Vente ".$codeoperation;
            $detail_vente->date_operation = $today;
            $detail_vente->debit = ($type == "Débit") ? $montant_net : 0;
            $detail_vente->credit = ($type == "Crédit") ? $montant_net : 0;
            // $detail_achat->solde = $total_debit - $total_credit;
            $detail_vente->save();

            $total_credit = Detailcompte::where('numero_compte',$compte1->numero_compte)->sum('credit');
            $total_debit = Detailcompte::where('numero_compte',$compte1->numero_compte)->sum('debit');

            $client->solde = $total_debit - $total_credit;
            $client->date_dernier_calcul_solde = new DateTime();
            $client->save();
            return $compte1->numero_compte;
      }

      /**
       * total debit et credit marche avec id compte client 
      */
      public function updateSoldeClient($client){
            $total_debit = Compteclient::getTotalDebit($client->id);
            $total_credit = Compteclient::getTotalCredit($client->id);
            $client->solde = $total_debit - $total_credit;
            $client->date_dernier_calcul_solde = new DateTime();
            $client->save();
      }

      public function updateJournalVente($numerocompte, $vente){
            // id(compteclient,tiket), 03 montant, dateoper
            $journal = new Journalvente;
            $journal->numero_compte = $numerocompte;
            $journal->vente_id = $vente->id;
            $journal->montant = $vente->montant_net;
            $journal->date_facturation = $vente->date_operation;
            $journal->save();
      }

      public function soldVente($client, $codevente, $montant, $caisseid){
            $today= new DateTime();
            // $idcompte = $this->updateComptaClient($client,$montant,$today,"Crédit");
            // $compte_caisse = new Comptecaisse;
            // $compte_caisse->libele_operation = "Reglement vente ". $codevente;
            // $compte_caisse->debit = $montant;
            // $compte_caisse->date_operation = $today;
            // $compte_caisse->save();

            // === New Impl : ============================================
            // $caisse = DataService::getFirstCaisseDepot($client->depot_id);
            $caisse = Caisse::find($caisseid);
            // operation compta caisse
            $compte1 = Compte::where('intitule', $caisse->libelle)->first();
            $detail_caisse = new Detailcompte;
            $detail_caisse->numero_compte = $compte1->numero_compte;
            $detail_caisse->reference_operation = 'Reglement vente '. $codevente;
            $detail_caisse->date_operation = $today;
            $detail_caisse->debit = $montant;
            $detail_caisse->save();

            // operation compta founissue
            $numcompte = $this->updateComptaClient($client, $codevente, $montant,$today,"Crédit");

            $this->checkVentePaid($codevente);
      }

      // utilise pour set le statut de la vente a true pour dire ; reglé
      public function checkVentePaid($codevente){
            // modifie pour prendre en ompte le depot
            $vente = $this->getVenteByCode($codevente);
            $totalvente = Journalvente::getMontantFacture($vente->id);

            // $deja_paye = Comptecaisse::MontantReglementVente($vente->code_vente);
            $libele = 'Reglement vente '. $codevente;
            $montant = Detailcompte::where('reference_operation',$libele)->sum('debit');
            $deja_paye = $montant != null ? $montant : 0;
            
            $reste = $totalvente - $deja_paye;
            if($reste <= 0){
                  $vente->statut = true;
                  $vente->save();
            }
      }

      /**
       * Suivi des compte Client: 
       * affiche: client, nom du compte ligne du journal des vente: debit et credit, 
      */
      public function ClientActivities($id_depot, $clientname){
            $client= Client::getClient($clientname,$id_depot);
            $ventes = Vente::ListVentePerClient($id_depot, $client->id);
            $compte = Compte::where('intitule', $client->nom_complet)->first();
            
            $activities = collect();
            foreach($ventes as $vente){
                  $details = Detailcompte::where('numero_compte',$compte->numero_compte) 
                        ->where('reference_operation','LIKE','%'.$vente->code_vente.'%')
                        ->get();
                  $details->map(function($item) use ($vente, $activities){
                        $ligne = [
                              'client'  => $vente->client->nom_complet,
                              'codevente'  => $vente->code_vente,
                              'total'  => $vente->montant_net,
                              'date_operation'  => $vente->date_operation,
                              'credit'  => $item->credit,
                              'debit'  => $item->debit
                        ];
                        $activities->push($ligne);
                  });
            }
            return $activities;
      }
}