-- 4.c : 5 zones de livraison
INSERT INTO lvr_zone (nom, pourcentage) VALUES
('Zone Analamahitsy', 12.50),
('Zone Anosizato', 12.50),
('Zone Ivato', 12.50),
('Zone Centre-Ville', 0.00),
('Zone Ankorondrano', 0.00);

-- 4.a : 10 véhicules
INSERT INTO lvr_vehicule (modele, immatriculation) VALUES
('Toyota Yaris', 'T 1001 AA'),
('Renault Clio', 'T 1002 BB'),
('Peugeot 208', 'T 1003 CC'),
('Hyundai i10', 'T 1004 DD'),
('Suzuki Swift', 'T 1005 EE'),
('Dacia Sandero', 'T 1006 FF'),
('Kia Picanto', 'T 1007 GG'),
('Ford Fiesta', 'T 1008 HH'),
('Volkswagen Polo', 'T 1009 II'),
('Citroën C3', 'T 1010 JJ');

-- 4.b : 12 livreurs/chauffeurs
INSERT INTO lvr_livreur (nom, contact, salaire) VALUES
-- Groupe 15000 Ar
('Rakoto Andry', '034 11 111 11', 15000.00),
('Rasoanirina Mbolatiana', '033 22 222 22', 15000.00),
('Razafy Jean', '032 33 333 33', 15000.00),
('Randria Luc', '034 44 444 44', 15000.00),
('Ramarojaona Eric', '033 55 555 55', 15000.00),
-- Groupe 18000 Ar
('Rabeharisoa Solo', '032 66 666 66', 18000.00),
('Razafindrakoto Hery', '034 77 777 77', 18000.00),
('Andriamanalina Tiana', '033 88 888 88', 18000.00),
-- Groupe 20000 Ar
('Razafimanantsoa Niry', '032 99 999 99', 20000.00),
('Andrianjafy Bruno', '034 00 000 00', 20000.00),
('Rasoloarison Dina', '033 11 000 11', 20000.00),
('Rakotomalala Faly', '032 22 111 22', 20000.00);


INSERT INTO lvr_statut (descrip) VALUES
('En attente'),
('Livré'),
('Annulée');

INSERT INTO lvr_colis (descrip, destinataire, contact, poids_Kg, adrDestination) VALUES
('Carton de vêtements', 'Rasoamiaramanana Holy', '034 56 789 01', 12.5, 'Lot II Y 45 Bis Anjanahary'),
('Paquet de livres scolaires', 'Razafindrakoto Lala', '033 12 345 67', 8.0, '67 Ha Sud Antsahabe'),
('Colis fragile - Verres et vaisselle', 'Andriamahazo Mirana', '032 98 765 43', 15.0, 'Imerinafovoany Talatamaty'),
('Sac de riz 25kg', 'Rakotondrainibe Thierry', '034 00 111 22', 25.0, 'Anosiala Ambohidratrimo'),
('Boîte d\'électroménager (mixeur)', 'Rasoloarisoa Nantenaina', '033 44 555 66', 4.5, 'Androndra Antananarivo Centre');