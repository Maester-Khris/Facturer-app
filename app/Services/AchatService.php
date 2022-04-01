<?php
namespace App\Services;

use App\Models\Facture;
use App\Models\Fournisseur;
use App\Models\Comptefournisseur;
use App\Models\Comptecaisse;
use App\Models\Personnel;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use App\Models\Marchandise;
use App\Models\Journalachat;
use DateTime;

class AchatService{

      public function getFourni($founi){
           return Fournisseur::getFournisseur($founi);
      }
      public function getFourniId($founi){
            return Fournisseur::getFournisseurId($founi);
      }
      public function getFourniSolde($founi){
            return Fournisseur::getFournisseurSolde($founi);
      }
      public function listFacture($id_depot){
            return Facture::getFacList($id_depot);
      }
      public function allDepotFactureCount($id_depot){
            return Facture::countFactures($id_depot);
      }
      public function ListUnSoldedFactures($id_depot){
            return Facture::unSoldedFactures($id_depot);
      }


      /**
       * Enregistrement facture et operations comptables
      */
      public function newFacture($idfournisseur,$codefac,$total,$remise,$net,$date){
            $facture = Facture::create([
                  'fournisseur_id' => $idfournisseur, 
                  'code_facture' => $codefac, 
                  'montant_total' => $total, 
                  'montant_remise' => $remise, 
                  'montant_net' => $net, 
                  'date_facturation' => $date,
                  'statut' => false
            ]);
            return $facture;
      }

      public function updateJournalAchat($facture, $comptefourni_id){
            $journal = new Journalachat;
            $journal->comptefournisseur_id = $comptefourni_id;
            $journal->facture_id = $facture->id;
            $journal->date_facturation = $facture->date_facturation;
            $journal->montant = $facture->montant_net;
            $journal->save();
      }

      public function UpdateSoldeFourni($fournisseur){
            $total_debit = Comptefournisseur::getTotalDebit($fournisseur->id);
            $total_credit = Comptefournisseur::getTotalCredit($fournisseur->id);
            $fournisseur->solde = $total_debit - $total_credit;
            $fournisseur->date_dernier_calcul_solde = new DateTime();
            $fournisseur->save();
      }

      public function updateComptaFournisseurs($founi,$montant_net,$today,$type){
            $fournisseur = Fournisseur::where('nom',$founi)->first();
            $compte = Comptefournisseur::create([
                  'fournisseur_id' => $fournisseur->id,
                  'debit' => ($type == "Débit") ? $montant_net : 0,
                  'credit' => ($type == "Crédit") ? $montant_net : 0,
                  'date_debit' => ($type == "Débit") ? $today : null,
                  'date_credit' => ($type == "Crédit") ? $today : null,
            ]);
           
            // $fournisseur->compte->save($compte);
            // calcul du new solde fournisseur 
            $this->UpdateSoldeFourni($fournisseur);
            return $compte->id;
      }

      /**
       * Regelement facture fournisseur: 
       *    ajout new debit dans compte fournisseur 
       *    update solde fourni
       *    on credite compte caisse: date op, montant, libelle, 
      */
      public function soldBill($founi, $codefac, $montant){
            $today= new DateTime();
            $idcompte = $this->updateComptaFournisseurs($founi,$montant,$today,"Débit");
            $compte_caisse = new Comptecaisse;
            $compte_caisse->libele_operation = "Reglement facture ". $codefac;
            $compte_caisse->credit = $montant;
            $compte_caisse->date_operation = $today;
            $compte_caisse->save();

            $this->checkBillSolded($codefac);
      }

      public function checkBillSolded($codefac){
            $facture = Facture::getByCodeFac($codefac);
            $totalfac = Journalachat::getMontantFacture($facture->id);
            $deja_paye = Comptecaisse::MontantReglementFacture($facture->code_facture);
            $reste = $totalfac - $deja_paye;
            if($reste == 0){
                  $facture->statut = true;
                  $facture->save();
            }
      }

      /**
       * Suivi des compte Fournisseur: 
       * affiche: founisseur, nom du compte ligne du journal des achat: debit et credit, 
       */
      public function ProviderActivities($id_depot, $founi){
            $id = $this->getFourniId($founi);
            return Fournisseur::FournisseurTransactions($id_depot,$id);
      }
      
}