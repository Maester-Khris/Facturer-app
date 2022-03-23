<?php
namespace App\Services;

use App\Models\Facture;
use App\Models\Fournisseur;
use App\Models\Comptefournisseur;
use App\Models\Personnel;
use App\Models\Stockdepot;
use App\Models\Mouvementstock;
use App\Models\Marchandise;
use App\Models\Journalachat;
use DateTime;

class AchatService{

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