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
 * Note Fonctionement : compte fournisseur et client
 * fournisseur
 * credité: apres approvisioneme -> reception facture a payer
 * debité: apres reglement de la facture 

 * client:
 * debite: apres vente -> ticket caisse (represente les somme facture aux client et non regle)
 * credite: lorsque client paye ticket (enregistre les montant regle par le client)
 * client paye on credite; apres facure avoir on credite
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
 *    montant augmente pour les ventes (debité): debit
 *     montant diminué pour les achat (credité): 
 * 
 * controle du solde de caisse en fin de journéé: 
 *    solde a l'ouverture + somme encaisse - somme decaissement
 *    compare avec solde compté physiquement
*/

/** Resume Achant vente (client, founissuer & caisse)
 * Vente: facture vente: cpt clt debite -> apres payement total: cpt clt credite -> cpt caisse debite; ecri journalvente
 * Achat: facture achat: cpt fr credite -> apres payement total: cpt clt debit -> cpt caisse credite; ecri journalachat
*/

/** vente comptoir
 * Apres cloture caisse: marquer facture de vente relgé 
 * implique jeux compte client et compte caisse
 * puisque c'est enfin de journe qu'on fait les vente:
 * facture d'avior pour ticket augmente juste le stock en avec la nouvelle facture negative
*/

/** Gestion des facture avoir:  pour erreur sur facture ou retour sur marchandise
 * augmenter le stock qui a ete reduit: (sans marquer de mvt stock)
 * effectuer un remboursement (jeu compe client / compte caisse)
 * client: credite le compte fournisseur, compte caisse (credite) ?
 * founisseur: debite le compte fournisseur, compte caisse (debite) ?
*/

/** App user
 * Murray - MAT0007
 * Johnny Brown - MAT0003
 * Randy - MAT0006
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