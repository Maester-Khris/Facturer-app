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

/** Notes Fonctionement : Etat d'inventaire
 * stock peut etre valorise soit au cmup soit au cout d'entree (peix achat ???)
 * CUMP : à l’occasion de chaque entrée en stock; = Total des coûts d’acquisition / Total des quantités
 * calcul du cmup a chaque entree stock = (Valeur du stock précédent à l’ancien CUMP + Coût d’acquisition de la nouvelle entrée) / Total des quantités en stock
 * valeur du stock a lancien cmup = nb articles * cout acquisition unitaire
 * valeur de la nouvelle entree = nb articles * cout acquisition
 * 
 * Chiffrez votre inventaire:
 * pour chaque référence stockée, nb article en stock * la valeur monétaire de chaque unité.
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
 * modifier facture et mouvement 
 * prendre en compte une facture concerne les produit d'un depot precis
 */

 /**
  * podcast list : 
  * https://open.spotify.com/show/7nda7u8PGTU2AfpLZ9ZR9Z
  * https://open.spotify.com/show/7vjdsslSmuMnDlqMFofict
  * https://open.spotify.com/show/2AOoWEcm5DwgA6rZylnzID
  * https://techbeacon.com/app-dev-testing/12-must-listen-software-engineering-podcast-episodes
*/

/**
 * Note de service: factur client
 * ajout de l'attribut de categorisation du client
 * dans facture client charger le prix en fonctoin de la categorisation du iencli
*/

/**
 * Note de service vente au comptoir: 
 * difference entre type paiment et type client
 * quel attribut pour enregistrer la categorisation du client
 * ajouter un attriut cloturé a ticket (1/0)
 * pour un ticket certain auront la possibilité de changer la tarification de vente
 * chaque vente au comptoir est enregistrer dans un ticket
 * en fin de journé on cree un vente, pour un client (par defaut) qui va contenir tout les ventes fait en journé
 * 
*/