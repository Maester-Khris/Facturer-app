<?php

/**
 * A Faire:
 * =========== Stock ==================================
 * tableau affichr order by date desc
 * pensez a mettre les date de stock en datetime, fournisseur et client + mouvement sotck, inventaire
 * pensez a modifier new mouvement et ses derive pour prendre la date en entree (reajust, newlignveinv) ♠
 * controle quantite en stock avant de faire transfert ♠
 * gerer situatuion depot ♠
 * liste marchandise coleur sur article en dessous du seuil ♠
 * pb avec les dates enregistré et affiché 
 * quantite en stock live dans ligne inventaire et reajuster ♠(enlevé)
 * inventaire difference valuer absolue ♠
 * inventaire padding bottom ♠
 * fix: save ligne inventaire ♠
 * 
 * =========== Achat ==================================
 * tableau à affichr order by date desc
 * fonction generer code new facture et l'envoyer a chaque fois qu'on ouvre index new facture ♠
 * liste des non paye ne prenne pas encore en compte le depot ♠
 * controle qte march avant vente et achat verifi qte seuil, qte optimal ♠
 * regler facture: desactiver les input et controler somme type number ♠
 * 
 * 
 * =========== Vente ==================================
 * reglement vente et acht mettre les date en datetime
 * fonction generer code new vente et l'envoyer a chaque fois qu'on ouvre index new vente ♠
 * liste des non paye ne prenne pas encore en compte le depot ♠
 * controle qte march avant vente et achat verifi qte seuil, qte optimal ♠
 * regler facture: desactiver les input et controler somme type number ♠
 * 
 * FACTURE: total  = total des ligne selectionné
*/

/**
 * Note Fonctionement : fournisseur et client
 * credité: apres approvisioneme -> reception facture a payer
 * debité: apres reglement de la facture

 * client:
 * debite: apres vente -> ticket caisse
 * credite: lorsque client paye ticket

 * solde compte = diff(total(debit) - total(credit))
*/

 /** Notes Fonctionement : Journal comptable
 * journal des achat et ventes
 * contient: facture, compte concerne, montant, date
 * a chaque fois qu'on cree fourinsseur/client on cree aussi leur compte
*/

/** Notes Fonctionement : Gestion compte caisse
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

 /* Notes Question au client:
      - combien de personne peuvent faire les ticket et les facture. connaitre le nom de l'employé
      - Quand est ce que on a besoin pour une facture de connaitre la liste des marchandises et les quantite
      comment gerer reajustement stock
*/

/**
 * confondre sa comptabilite personnel et sa comptabilite d'entreprise en At c'est apprendre
 * sur son lieu de travail ce qu'on aurait du apprendre sur son temps libre
 * difference entre la passion et la corvée et le rapport sur le niveau du productivite
 * cour sur le college de france
 */

 /**
  * podcast list : 
  * https://open.spotify.com/show/7nda7u8PGTU2AfpLZ9ZR9Z
  * https://open.spotify.com/show/7vjdsslSmuMnDlqMFofict
  * https://open.spotify.com/show/2AOoWEcm5DwgA6rZylnzID
  * https://techbeacon.com/app-dev-testing/12-must-listen-software-engineering-podcast-episodes
*/