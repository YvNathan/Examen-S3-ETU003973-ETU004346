/* =========================
   ZONES
========================= */
INSERT INTO lvr_zone (nom) VALUES
('Zone Nord'),
('Zone Sud'),
('Zone Est'),
('Zone Ouest');

/* =========================
   VEHICULES
========================= */
INSERT INTO lvr_vehicule (modele, immatriculation) VALUES
('Renault Kangoo', 'AN123BC'),
('Peugeot Partner', 'BD456EF'),
('Fiat Ducato', 'CF789GH');

/* =========================
   LIVREURS
========================= */
INSERT INTO lvr_livreur (nom, contact, salaire) VALUES
('Jean Dupont', '0341234567', 50.00),
('Marie Durand', '0349876543', 55.00),
('Ali Raharimanana', '0341122334', 60.00);

/* =========================
   STATUTS
========================= */
INSERT INTO lvr_statut (descrip) VALUES
('En attente'),
('Livré'),
('Annulé');

/* =========================
   COLIS
========================= */
INSERT INTO lvr_colis (descrip, destinataire, contact, poids_Kg, adrDestination) VALUES
('Colis A', 'Alice', '0341111222', 10.5, '12 Rue Centrale, Zone Nord'),
('Colis B', 'Bob', '0343333444', 5.0, '45 Avenue Sud, Zone Sud'),
('Colis C', 'Charlie', '0345555666', 12.0, '78 Boulevard Est, Zone Est'),
('Colis D', 'David', '0347777888', 7.5, '90 Rue Ouest, Zone Ouest');

/* =========================
   AFFECTATIONS
========================= */
INSERT INTO lvr_affectation (idVehicule, idLivreur, coutVehicule) VALUES
(1, 1, 30.00),
(2, 2, 35.00),
(3, 3, 40.00);

/* =========================
   LIVRAISONS
========================= */
INSERT INTO lvr_livraison (idAffectation, idColis, adresseDepart, dateLivraison, prixKg) VALUES
(1, 1, 'Entrepôt Central', '2025-12-10', 2.0),
(2, 2, 'Entrepôt Central', '2025-12-11', 1.5),
(3, 3, 'Entrepôt Central', '2025-12-12', 2.5);

/* =========================
   LIVRAISONSTATUTS
========================= */
INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut) VALUES
(1, 1, '2025-12-10'),
(2, 1, '2025-12-11'),
(3, 1, '2025-12-12');

/* =========================
   PAIEMENTS
========================= */
-- Simuler paiements pour les livraisons livrées
INSERT INTO lvr_paiement (idLivraison, prix, datePaiement) VALUES
(1, 21.0, '2025-12-10'), 
(2, 7.5, '2025-12-11'), 
(3, 30.0, '2025-12-12'); 

/* =========================
   LIVRAISONSTATUTS APRES PAIEMENT
========================= */
INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut) VALUES
(1, 2, '2025-12-10'),
(2, 2, '2025-12-11'),
(3, 2, '2025-12-12');
