-- Statuts
INSERT INTO lvr_statut (`desc`) VALUES
('en attente'),
('livré'),
('annulé');

-- Véhicules
INSERT INTO lvr_vehicule (modele, immatriculation) VALUES
('Renault Kangoo', '1234 TBA'),
('Peugeot Partner', '4567 TBD'),
('Mercedes Sprinter', '7891 TCA'),

-- Livreurs
INSERT INTO lvr_livreur (nom, salaire_journalier, contact) VALUES
('Rakoto Jean', 10000, '034 12 345 67'),
('Ratefy Paul', 12000, '033 98 765 43');

-- Colis
INSERT INTO lvr_colis (descrip, poids_kg, destinataire) VALUES
('3 Macbook Pro M5', 6.2, 'Rasoarilalao Kanto'),
('5 iPhone 17 Pro Max', 1.5, 'Rarivoarison Joseph'),
('2 Imprimantes Laser HP', 22.0, 'Rajaonarivelo Hery'),
('Carton de vêtements (30 pièces)', 12.3, 'Randriamampionona Sarah'),
('Télévision LED 55 pouces', 16.8, 'Rabe Jean-Claude'),
('Lot de livres scolaires', 9.4, 'Razafindrakoto Mireille'),
('Machine à café professionnelle', 14.6, 'Raherison Paul'),
('Pièces détachées automobiles', 25.0, 'Ravelomanantsoa Thierry'),
('Smartphones Android (20 unités)', 4.9, 'Rasoanaivo Lala');

-- Conf
INSERT INTO lvr_conf_prix (prix, actif) VALUES (5, true);
