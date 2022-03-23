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

class VenteService{
      /**
       * journal vente contient id ticket, monant net remise et total
       * ticket ne comptient pas de de montant
       * ticket contient id marchandise, quantite, sur plusieur ligne date creation
       * ticket type de vente, indicatif ??
       * gerer le reglement de ticket passe toujours par compte caisse
       */
}