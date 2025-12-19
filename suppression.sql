UPDATE lvr_paiement SET idLivraison = NULL;

DELETE FROM lvr_livraisonStatut;

DELETE FROM lvr_livraison;

DELETE FROM lvr_affectation;

ALTER TABLE lvr_livraisonStatut AUTO_INCREMENT = 1;
ALTER TABLE lvr_livraison AUTO_INCREMENT = 1;
ALTER TABLE lvr_affectation AUTO_INCREMENT = 1;