

INSERT INTO lvr_statut (id, descrip) VALUES
(1, 'en attente'),
(2, 'livré'),
(3, 'annulé');


INSERT INTO lvr_vehicule (modele, immatriculation) VALUES
('Peugeot Expert', 'AB-123-CD'),
('Renault Kangoo', 'EF-456-GH'),
('Citroën Berlingo', 'IJ-789-KL'),
('Fiat Ducato', 'MN-012-OP');

INSERT INTO lvr_livreur (nom, contact, salaire) VALUES
('Ahmed Benali', '06 12 34 56 78', 1800.00),
('Sophie Martin', '06 98 76 54 32', 1950.00),
('Karim Dubois', '06 55 44 33 22', 1700.00),
('Léa Rousseau', '06 11 22 33 44', 1850.00);

-- 4. Colis (sans idZone évidemment)
INSERT INTO lvr_colis (descrip, destinataire, contact, poids_Kg, adrDestination) VALUES
('Carton électronique - TV 55"', 'M. Dupont', '06 01 02 03 04', 15.50, '12 Rue de la Paix, 75001 Paris'),
('Palette de livres', 'Librairie Centrale', '01 23 45 67 89', 120.00, '45 Avenue des Champs, 75008 Paris'),
('Colis fragile - Verres', 'Mme Lambert', '06 05 06 07 08', 8.20, '78 Rue du Faubourg, 93000 Bobigny'),
('Machine à café pro', 'Café des Sports', '01 99 88 77 66', 18.00, '3 Boulevard Voltaire, 95100 Argenteuil'),
('Meuble en kit', 'M. Traore', '06 33 44 55 66', 35.70, '156 Route Nationale, 95200 Sarcelles'),
('Matériel informatique', 'Entreprise TechLog', '01 55 66 77 88', 25.40, 'ZAC des Portes, 95300 Pontoise'),
('Colis réfrigéré - Produits frais', 'Supermarché Bio', '01 44 33 22 11', 12.80, '10 Place du Marché, 75002 Paris');

INSERT INTO lvr_colis (descrip, destinataire, contact, poids_Kg, adrDestination) VALUES
('Ordinateur portable', 'M. Martin', '06 12 34 56 78', 2.30, '24 Rue Victor Hugo, 92100 Boulogne-Billancourt'),
('Pièces automobiles', 'Garage Auto Plus', '01 47 58 69 70', 42.00, '8 Rue des Mécaniciens, 92000 Nanterre'),
('Colis express - Documents', 'Cabinet Juridique Alpha', '01 40 20 30 40', 1.10, '15 Avenue de l''Opéra, 75001 Paris'),
('Équipement sportif', 'Salle Fitness Pro', '01 34 56 78 90', 28.60, '99 Rue du Stade, 94000 Créteil'),
('Produits cosmétiques', 'Institut Beauté Zen', '01 22 33 44 55', 6.90, '4 Rue des Lilas, 93100 Montreuil'),
('Batteries industrielles', 'Société EnerTech', '01 88 77 66 55', 85.00, 'Zone Industrielle Nord, 95500 Gonesse'),
('Colis fragile - Œuvres d''art', 'Galerie Lumière', '01 60 70 80 90', 14.50, '27 Rue des Arts, 75003 Paris'),
('Matériel médical', 'Clinique Saint-Paul', '01 42 21 12 21', 19.80, '5 Avenue de la Santé, 75013 Paris'),
('Vêtements - Collection été', 'Boutique Mode Chic', '01 53 64 75 86', 9.40, '18 Rue du Commerce, 75015 Paris'),
('Composants électroniques', 'Startup Innovatek', '01 71 82 93 04', 3.75, '42 Rue des Startups, 75010 Paris');



-- Livraison 1 : livrée
CALL p_lvr_new_livraison(1, 1, 25.00, 45.00, 1, 5.50, '2025-12-10');
CALL p_gestion_statut(1, '2025-12-11');

-- Livraison 2 : livrée
CALL p_lvr_new_livraison(2, 2, 20.00, 50.00, 2, 4.80, '2025-12-12');
CALL p_gestion_statut(2, '2025-12-13');

-- Livraison 3 : annulée (perte visible dans les bénéfices)
CALL p_lvr_new_livraison(3, 3, 30.00, 40.00, 3, 6.00, '2025-12-14');
CALL p_annuler_livraison(3);

-- Livraison 4 : livrée
CALL p_lvr_new_livraison(4, 4, 35.00, 48.00, 4, 7.20, '2025-12-15');
CALL p_gestion_statut(4, '2025-12-16');

-- Livraison 5 : en attente (n'apparaît pas dans les bénéfices)
CALL p_lvr_new_livraison(1, 2, 22.00, 52.00, 5, 5.00, '2025-12-18');

-- Livraison 6 : livrée (même jour que la 5 pour tester le grouping par jour)
CALL p_lvr_new_livraison(2, 1, 28.00, 46.00, 6, 6.50, '2025-12-18');
CALL p_gestion_statut(6, '2025-12-19');

-- Livraison 7 : livrée
CALL p_lvr_new_livraison(3, 4, 40.00, 55.00, 7, 4.20, '2025-12-17');
CALL p_gestion_statut(7, '2025-12-18');