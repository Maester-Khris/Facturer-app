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

      /* Notes:
      - combien de personne peuvent faire les ticket et les facture. connaitre le nom de l'employé
      - pensez a mettre les date de stock en datetime, fournisseur et client + mouvement sotck, inventaire
      - Quand est ce que on a besoin pour une facture de connaitre la liste des marchandises et les quantite
      - tableau à affichr order by date desc
      - fonction generer code new facture et l'envoyer a chaque fois qu'on ouvre index new facture
      - quand est ce que on appelle updateprovider account
      - liste des non paye ne prenne pas encore en compte le depot
      - reglement vente et acht mettre les date en datetime
      - liste marchandise coleur sur article en dessous du seuil
      -  admin gestion du journal comptable
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

      /** Notes: Journal comptable
       * journal des achat et ventes
       * contient: facture, compte concerne, montant, date
       * a chaque fois qu'on cree fourinsseur/client on cree aussi leur compte
      */

      /** Gestion compte caisse
       * solde doit etre debiteur ou null
       * total des ventes journalieres
       * detail: date, designation, prix, libele des operations
       * operation compta
       *    montant augmente pour les ventes (debité)
       *     montant diminué pour les achat (credité)
       * 
       * controle du solde de caisse en fin de journéé: 
       *    solde a l'ouverture + somme encaisse - somme decaissement
       *    compare avec solde compté physiquement
      */

      /**
       * Fonctions utilitaires
      */
      public function getFourni($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni;
      }

      public function getFourniId($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni->id;
      }

      public function getFourniSolde($founi){
            $fourni = Fournisseur::where('nom', $founi)->first();
            return $fourni->solde;
      }

      /**
       * Liste des factures d'achat d'un depot
      */
      public function listFacture($id_depot){
            return Facture::getFacList($id_depot);
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

      public function UpdateSoldeFourni($fournisseur, $date){
            $total_debit = Comptefournisseur::getTotalDebit($fournisseur->id);
            $total_credit = Comptefournisseur::getTotalCredit($fournisseur->id);
            $fournisseur->solde = $total_debit - $total_credit;
            $fournisseur->date_dernier_calcul_solde = $date;
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
            $this->UpdateSoldeFourni($fournisseur, $today);
            return $compte->id;
      }

      /**
       * Regelement facture fournisseur: 
       *    ajout new debit dans compte fournisseur 
       *    update solde fourni
       *    on credite compte caisse: date op, montant, libelle, 
      */
      public function soldBill($founi, $codefac, $montant){
            $today= date("Y-m-d");
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