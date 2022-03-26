<?php
namespace App\Services;

use App\Models\Client;
use App\Models\Compteclient;
use App\Models\Comptecaisse;
use App\Models\Marchandise;
use App\Models\Journalvente;
use App\Models\Vente;
use App\Models\Ticket;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use DateTime;

class VenteService{

      /**
       * avant de faire la vente controle de quantite en stock
       * avant d'enregistrer la facture ou la vente controle du code:
       *    nb de ligne deja en bd et format
      */

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

      /* Notes fonctionement des compte: fournisseur et client
       fournisseur: 
       - credité: apres approvisioneme -> reception facture a payer
       - debité: apres reglement de la facture

       client:
       - debite: apres vente -> ticket caisse
       - credite: lorsque client paye ticket

       solde compte = diff(total(debit) - total(credit))
      */

      public function ListVente($id_depot){
           return Vente::allVente($id_depot);
      }
      public static function getVenteByCode($codevente){
           return Vente::getByCode($codevente);
      }
      public function ListNonPaidVentes(){
           return Vente::unpaidVente();
      }
      public function getClientSolde($client){
           return Client::retrieveSold($client);
      }


      public function newVente($client_id,$comptoir_id,$codevente,$montants,$marchs,$date){
            $vente = Vente::create([
                  'client_id' => $client_id, 
                  'comptoir_id' => $comptoir_id, 
                  'code_vente' => $codevente, 
                  'montant_remise' => $montants[0], 
                  'montant_total' => $montants[1], 
                  'montant_net' => $montants[2], 
                  'indicatif' => 0,
                  'date_operation' => $date
            ]);

            foreach($marchs as $march){
                  $march_id =  Marchandise::getMarchId($march['name']);
                  $prix = $march['type_vente'] == "Detail" ? Marchandise::getMarchPrixDet($march_id) : Marchandise::getMarchPrixGro($march_id);
                  $ticket = Ticket::create([
                        'vente_id' => $vente->id, 
                        'marchandise_id' => $march_id, 
                        'quantite' => $march['quantite'], 
                        'type_vente' => $march['type_vente'],
                        'prix_vente' => $prix
                  ]);
            }
            return  $vente; 
      }

      /**
       * compte client fait un debit
       * return id compte client
      */
      public function updateComptaClient($client,$montant_net,$today,$type){
            $compte = Compteclient::create([
                  'client_id' => $client->id,
                  'debit' => ($type == "Débit") ? $montant_net : 0,
                  'credit' => ($type == "Crédit") ? $montant_net : 0,
                  'date_debit' => ($type == "Débit") ? $today : null,
                  'date_credit' => ($type == "Crédit") ? $today : null,
            ]);
           
            // calcul du new solde fournisseur 
            $this->updateSoldeClient($client, $today);
            return $compte->id;
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

      public function updateJournalVente($compteclient_id, $vente, $montant){
            // id(compteclient,tiket), 03 montant, dateoper
            $journal = new Journalvente;
            $journal->compteclient_id = $compteclient_id;
            $journal->vente_id = $vente->id;
            $journal->montant = $montant;
            $journal->date_facturation = $vente->date_operation;
            $journal->save();
      }

      public function soldVente($client, $codevente, $montant){
            $today= date("Y-m-d");
            $idcompte = $this->updateComptaClient($client,$montant,$today,"Crédit");
            $compte_caisse = new Comptecaisse;
            $compte_caisse->libele_operation = "Reglement vente ". $codevente;
            $compte_caisse->debit = $montant;
            $compte_caisse->date_operation = $today;
            $compte_caisse->save();

            $this->checkVentePaid($codevente);
      }

      public function checkVentePaid($codevente){
            $vente = $this->getVenteByCode($codevente);
            $totalvente = Journalvente::getMontantFacture($vente->id);
            $deja_paye = Comptecaisse::MontantReglementVente($vente->code_vente);
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
      public function ClientActivities($id_depot, $client){
            $id = Client::getClientId($client,$id_depot);
            return Client::ClientTransactions($id_depot,$id);
      }

      
}