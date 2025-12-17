
-- ZONES
INSERT INTO lvr_zone (id, nom) VALUES
(1, 'Centre-ville'),
(2, 'Analamanga'),
(3, 'Androy');

-- VEHICULES
INSERT INTO lvr_vehicule (id, modele, immatriculation) VALUES
(1, 'Toyota Hilux', '1234-TAB'),
(2, 'Nissan NV200', '5678-TBC'),
(3, 'Suzuki Carry', '9012-TBD');

-- LIVREURS
INSERT INTO lvr_livreur (id, nom, contact, salaire) VALUES
(1, 'Rakoto Jean', '0341234567', 450000),
(2, 'Rabe Paul', '0329876543', 400000),
(3, 'Andry Marc', '0334567890', 420000);

-- STATUTS
INSERT INTO lvr_statut (id, descrip) VALUES
(1, 'En attente'),
(2, 'En cours de livraison'),
(3, 'Livré');

-- COLIS
INSERT INTO lvr_colis (id, descrip, destinataire, contact, poids_Kg, adrDestination, idZone) VALUES
(1, 'Documents', 'Société ABC', '0348512301', 2.50, 'IB102', 1),
(2, 'Matériel informatique', 'Entreprise XYZ', '0345689213', 5.00, 'IV001', 2),
(3, 'Vêtements', 'Client Particulier', '0332540157', 3.20, 'IB09', 3);






