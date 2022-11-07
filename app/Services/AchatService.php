<?php
namespace App\Services;

use App\Models\Compte;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Personnel;
use App\Models\Stockdepot;
use App\Models\Fournisseur;
use App\Models\Marchandise;
use App\Models\Comptecaisse;
use App\Models\Journalachat;
use App\Models\Detailcompte;
use App\Models\Mouvementstock;
use App\Models\Comptefournisseur;
use App\Services\DataService;
use DateTime;

class AchatService{

      public function getFourni($id_depot, $founi){
           return Fournisseur::getFournisseur($id_depot, $founi);
      }
      public function getFourniId($id_depot, $founi){
            return Fournisseur::getFournisseurId($id_depot, $founi);
      }
      public function getFourniSolde($depot, $founi){
            return Fournisseur::getFournisseurSolde($depot, $founi);
      }
      public function listFacture($id_depot){
            return Facture::getAllFacturesByDepot($id_depot);
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

      public function updateJournalAchat($facture, $numerocompte){
            $journal = new Journalachat;
            $journal->numero_compte = $numerocompte;
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

      public function updateComptaFournisseurs($fournisseur,$codeoperation,$montant_net,$today,$type){
            // $fournisseur = Fournisseur::where('nom_complet',$founi)->first();
            // $compte = Comptefournisseur::create([
            //       'fournisseur_id' => $fournisseur->id,
            //       'debit' => ($type == "Débit") ? $montant_net : 0,
            //       'credit' => ($type == "Crédit") ? $montant_net : 0,
            //       'date_debit' => ($type == "Débit") ? $today : null,
            //       'date_credit' => ($type == "Crédit") ? $today : null,
            // ]);
            // $this->UpdateSoldeFourni($fournisseur);
            // return $compte->id;

            // ========= Nouvelle Impl: marque l'op comptable en mettant ajour le solde du compte 
            $compte1 = Compte::where('intitule', $fournisseur->nom_complet)->first();
           
            $detail_achat = new Detailcompte;
            $detail_achat->numero_compte = $compte1->numero_compte;
            $detail_achat->reference_operation = "Facture d'achat ".$codeoperation;
            $detail_achat->date_operation = $today;
            $detail_achat->debit = ($type == "Débit") ? $montant_net : 0;
            $detail_achat->credit = ($type == "Crédit") ? $montant_net : 0;
            // $detail_achat->solde = $total_debit - $total_credit;
            $detail_achat->save();

            $total_credit = Detailcompte::where('numero_compte',$compte1->numero_compte)->sum('credit');
            $total_debit = Detailcompte::where('numero_compte',$compte1->numero_compte)->sum('debit');

            $fournisseur->solde = $total_debit - $total_credit;
            $fournisseur->date_dernier_calcul_solde = new DateTime();
            $fournisseur->save();

            // ========= Nouvelle Impl: marque l'op comptable en mettant ajour le solde du compte 

            return $compte1->numero_compte;
      }



      /**
       * Regelement facture fournisseur: 
       *    ajout new debit dans compte fournisseur 
       *    update solde fourni
       *    on credite compte caisse: date op, montant, libelle, 
      */
      public function soldBill($fournisseur, $codefac, $montant, $caisseid){
            $today= new DateTime();
            // $idcompte = $this->updateComptaFournisseurs($founi,$montant,$today,"Débit");
            // $compte_caisse = new Comptecaisse;
            // $compte_caisse->libele_operation = "Reglement facture ". $codefac;
            // $compte_caisse->credit = $montant;
            // $compte_caisse->date_operation = $today;
            // $compte_caisse->save();

            // === New Impl : ============================================
            // $fournisseur = Fournisseur::where('nom_complet',$founi)->first();
            // $caisse = DataService::getFirstCaisseDepot($fournisseur->depot_id);
            $caisse = Caisse::find($caisseid);
            // operation compta caisse
            $compte1 = Compte::where('intitule', $caisse->libelle)->first();
            $detail_caisse = new Detailcompte;
            $detail_caisse->numero_compte = $compte1->numero_compte;
            $detail_caisse->reference_operation = 'Reglement facture '. $codefac;
            $detail_caisse->date_operation = $today;
            $detail_caisse->credit = $montant;
            $detail_caisse->save();

            // operation compta founissue
            $numcompte = $this->updateComptaFournisseurs($fournisseur,$codefac,$montant,$today,"Débit");
            
            $this->checkBillSolded($codefac);
      }

      public function checkBillSolded($codefac){
            $facture = Facture::getByCodeFac($codefac);
            $totalfac = Journalachat::getMontantFacture($facture->id);

      
            $libele = 'Reglement facture '. $codefac;
            $montant = Detailcompte::where('reference_operation',$libele)->sum('credit');
            $deja_paye = $montant != null ? $montant : 0;

            $reste = $totalfac - $deja_paye;
            if($reste <= 0){
                  $facture->statut = true;
                  $facture->save();
            }
      }

      /**
       * Suivi des compte Fournisseur: 
       * affiche: founisseur, nom du compte ligne du journal des achat: debit et credit, 
       */
      public function ProviderActivities($id_depot, $founi){
            $fourni = $this->getFourni($id_depot,$founi);
            $factures = Facture::getFacFourniList($id_depot, $fourni->id);
            $compte = Compte::where('intitule', $fourni->nom_complet)->first();

            $activities = collect();
            foreach($factures as $fac){
                  $details = Detailcompte::where('numero_compte',$compte->numero_compte) 
                  ->where('reference_operation','LIKE','%'.$fac->code_facture.'%')
                  ->get();
                  $details->map(function($item) use ($fac, $activities){
                        $ligne = [
                              'fournisseur'  => $fac->fournisseur->nom_complet,
                              'codefac'  => $fac->code_facture,
                              'total'  => $fac->montant_net,
                              'date_operation'  => $fac->date_facturation,
                              'credit'  => $item->credit,
                              'debit'  => $item->debit
                        ];
                        $activities->push($ligne);
                  });
            }
            return $activities;
      }
      
}