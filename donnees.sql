-- Chauffeurs
INSERT INTO kptv_chauffeurs (nom, contact) VALUES
('RAKOTO Jean', '032 12 345 67'),
('RASOA Marie', '033 45 678 90'),
('RABE Paul', '034 23 456 78'),
('RANDRIANASOLO Michel', '032 98 765 43'),
('RAHARISON Sophie', '033 87 654 32'),
('ANDRIAMARO Rivo', '034 76 543 21'),
('RAZAFY Claude', '032 65 432 10'),
('RATSIMANOHATRA Fidiniaina', '033 54 321 09'),
('RANDRIANAIVO Joseph', '034 43 210 98'),
('RASOAMALALA Honoré', '032 32 109 87'),
('RAKOTONIRINA Hery', '033 21 098 76'),
('ANDRIANJAFY René', '034 10 987 65'),
('RATOVOSON Solo', '032 09 876 54'),
('RAMAHAVALISOA Niry', '033 98 765 43'),
('RANAIVOSON Haja', '034 87 654 32');

-- Voitures
INSERT INTO kptv_vehicules (modele, immatriculation, capacite, min_versement) VALUES
('Toyota Hiace', '1234 TAU', 12, 80000.00),
('Mazda E2200 Cargo', '2156 TU', 10, 60000.00),
('Sprinter Phase 1', '3421 TAA', 14, 75000.00),
('Toyota Hiace', '4567 TAU', 11, 70000.00),
('Crafter Phase 1', '5678 TAM', 13, 78000.00),
('Sprinter Phase 2', '6789 TBA', 16, 100000.00),
('Toyota Hiace', '7890 TBE', 14, 90000.00),
('Crafter Phase 2', '8901 TBE', 15, 95000.00),
('Mazda E2200 Cargo', '9012 TBD', 12, 85000.00),
('Sprinter Phase 1', '1023 TBA', 15, 92000.00),
('Sprinter Phase 2', '2134 TCA', 18, 120000.00),
('Crafter Phase 2', '3245 TCA', 17, 150000.00),
('Toyota Hiace', '4356 TCA', 16, 130000.00),
('Sprinter Phase 2', '5467 TCA', 18, 145000.00),
('Crafter Phase 2', '6578 TBE', 17, 140000.00);

-- Parcours
INSERT INTO kptv_parcours (lieu_depart, lieu_arrivee, distance) VALUES
('67 Ha', 'Anosibe', 12.50),
('Analakely', 'Ambohimanarina', 8.30),
('Ampasampito', 'Ambatobe', 6.20),
('Behoririka', 'Ankadifotsy', 4.50),
('Soarano', 'Andohalo', 3.80),
('Analakely', 'Ambohijatovo', 5.60),
('Tsaralalana', 'Ankorondrano', 7.40),
('Ambohijatovo', 'Anosy', 4.20),
('Isotry', 'Mahamasina', 3.50),
('Analakely', 'Ampefiloha', 6.80),
('Behoririka', 'Ambanidia', 9.20),
('Ampasampito', 'Ambohitrarahaba', 11.50),
('Soarano', 'Mahazo', 14.30),
('Analakely', 'Ivato', 15.80),
('67 Ha', 'Ambohimangakely', 10.70),
('Behoririka', 'Ambohidratrimo', 13.40),
('Analakely', 'Tanjombato', 16.50),
('Tsaralalana', 'Andraisoro', 5.90),
('Ambohijatovo', 'Faravohitra', 2.80),
('Isotry', 'Antohomadinika', 4.60);

-- Trajets (sans recette et carburant)
-- Parcours 1
-- 12 dec
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(1, '2025-12-12 06:00:00', '2025-12-12 06:45:00', 'A'),
(1, '2025-12-12 07:00:00', '2025-12-12 07:40:00', 'R'),
(1, '2025-12-12 08:30:00', '2025-12-12 09:15:00', 'A'),
(1, '2025-12-12 09:30:00', '2025-12-12 10:10:00', 'R'),
(1, '2025-12-12 11:00:00', '2025-12-12 11:45:00', 'A'),
(1, '2025-12-12 12:00:00', '2025-12-12 12:40:00', 'R');

-- 13 dec
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(1, '2025-12-13 06:15:00', '2025-12-13 07:00:00', 'A'),
(1, '2025-12-13 07:15:00', '2025-12-13 07:55:00', 'R'),
(1, '2025-12-13 09:00:00', '2025-12-13 09:45:00', 'A'),
(1, '2025-12-13 10:00:00', '2025-12-13 10:40:00', 'R');

-- Parcours 2
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(2, '2025-12-12 07:30:00', '2025-12-12 08:00:00', 'A'),
(2, '2025-12-12 08:15:00', '2025-12-12 08:45:00', 'R'),
(2, '2025-12-12 10:00:00', '2025-12-12 10:30:00', 'A'),
(2, '2025-12-12 10:45:00', '2025-12-12 11:15:00', 'R'),
(2, '2025-12-13 08:00:00', '2025-12-13 08:30:00', 'A'),
(2, '2025-12-13 08:45:00', '2025-12-13 09:15:00', 'R');

-- Parcours 3
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(3, '2025-12-12 06:45:00', '2025-12-12 07:10:00', 'A'),
(3, '2025-12-12 07:25:00', '2025-12-12 07:50:00', 'R'),
(3, '2025-12-12 09:15:00', '2025-12-12 09:40:00', 'A'),
(3, '2025-12-12 09:55:00', '2025-12-12 10:20:00', 'R'),
(3, '2025-12-13 07:00:00', '2025-12-13 07:25:00', 'A'),
(3, '2025-12-13 07:40:00', '2025-12-13 08:05:00', 'R');

-- Parcours 4
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(4, '2025-12-12 08:00:00', '2025-12-12 08:20:00', 'A'),
(4, '2025-12-12 08:35:00', '2025-12-12 08:55:00', 'R'),
(4, '2025-12-12 11:30:00', '2025-12-12 11:50:00', 'A'),
(4, '2025-12-12 12:05:00', '2025-12-12 12:25:00', 'R');

-- Parcours 5
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(5, '2025-12-12 09:00:00', '2025-12-12 09:18:00', 'A'),
(5, '2025-12-12 09:30:00', '2025-12-12 09:48:00', 'R'),
(5, '2025-12-13 09:15:00', '2025-12-13 09:33:00', 'A'),
(5, '2025-12-13 09:45:00', '2025-12-13 10:03:00', 'R');

-- Parcours 6
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(6, '2025-12-12 07:00:00', '2025-12-12 07:25:00', 'A'),
(6, '2025-12-12 07:40:00', '2025-12-12 08:05:00', 'R'),
(6, '2025-12-12 10:30:00', '2025-12-12 10:55:00', 'A'),
(6, '2025-12-12 11:10:00', '2025-12-12 11:35:00', 'R');

-- Parcours 7
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(7, '2025-12-12 06:30:00', '2025-12-12 07:05:00', 'A'),
(7, '2025-12-12 07:20:00', '2025-12-12 07:55:00', 'R'),
(7, '2025-12-13 06:45:00', '2025-12-13 07:20:00', 'A'),
(7, '2025-12-13 07:35:00', '2025-12-13 08:10:00', 'R');

-- Parcours 8
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(8, '2025-12-12 08:30:00', '2025-12-12 08:50:00', 'A'),
(8, '2025-12-12 09:05:00', '2025-12-12 09:25:00', 'R'),
(8, '2025-12-13 08:45:00', '2025-12-13 09:05:00', 'A'),
(8, '2025-12-13 09:20:00', '2025-12-13 09:40:00', 'R');

-- Parcours 9
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(9, '2025-12-12 10:00:00', '2025-12-12 10:17:00', 'A'),
(9, '2025-12-12 10:30:00', '2025-12-12 10:47:00', 'R'),
(9, '2025-12-13 10:15:00', '2025-12-13 10:32:00', 'A'),
(9, '2025-12-13 10:45:00', '2025-12-13 11:02:00', 'R');

-- Parcours 10
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(10, '2025-12-12 07:30:00', '2025-12-12 08:00:00', 'A'),
(10, '2025-12-12 08:15:00', '2025-12-12 08:45:00', 'R'),
(10, '2025-12-13 07:45:00', '2025-12-13 08:15:00', 'A'),
(10, '2025-12-13 08:30:00', '2025-12-13 09:00:00', 'R');

-- Parcours 11
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(11, '2025-12-12 06:00:00', '2025-12-12 06:40:00', 'A'),
(11, '2025-12-12 06:55:00', '2025-12-12 07:35:00', 'R'),
(11, '2025-12-13 06:15:00', '2025-12-13 06:55:00', 'A'),
(11, '2025-12-13 07:10:00', '2025-12-13 07:50:00', 'R');

-- Parcours 12
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(12, '2025-12-12 08:00:00', '2025-12-12 08:50:00', 'A'),
(12, '2025-12-12 09:05:00', '2025-12-12 09:55:00', 'R'),
(12, '2025-12-13 08:15:00', '2025-12-13 09:05:00', 'A'),
(12, '2025-12-13 09:20:00', '2025-12-13 10:10:00', 'R');

-- Parcours 13
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(13, '2025-12-12 06:30:00', '2025-12-12 07:25:00', 'A'),
(13, '2025-12-12 07:40:00', '2025-12-12 08:35:00', 'R'),
(13, '2025-12-13 06:45:00', '2025-12-13 07:40:00', 'A'),
(13, '2025-12-13 07:55:00', '2025-12-13 08:50:00', 'R');

-- Parcours 14
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(14, '2025-12-12 05:30:00', '2025-12-12 06:30:00', 'A'),
(14, '2025-12-12 06:45:00', '2025-12-12 07:45:00', 'R'),
(14, '2025-12-12 09:00:00', '2025-12-12 10:00:00', 'A'),
(14, '2025-12-12 10:15:00', '2025-12-12 11:15:00', 'R');

-- Parcours 15
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(15, '2025-12-12 07:00:00', '2025-12-12 07:50:00', 'A'),
(15, '2025-12-12 08:05:00', '2025-12-12 08:55:00', 'R'),
(15, '2025-12-13 07:15:00', '2025-12-13 08:05:00', 'A'),
(15, '2025-12-13 08:20:00', '2025-12-13 09:10:00', 'R');

-- Parcours 16
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(16, '2025-12-12 06:15:00', '2025-12-12 07:15:00', 'A'),
(16, '2025-12-12 07:30:00', '2025-12-12 08:30:00', 'R'),
(16, '2025-12-13 06:30:00', '2025-12-13 07:30:00', 'A'),
(16, '2025-12-13 07:45:00', '2025-12-13 08:45:00', 'R');

-- Parcours 17
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(17, '2025-12-12 06:00:00', '2025-12-12 07:05:00', 'A'),
(17, '2025-12-12 07:20:00', '2025-12-12 08:25:00', 'R'),
(17, '2025-12-13 06:15:00', '2025-12-13 07:20:00', 'A'),
(17, '2025-12-13 07:35:00', '2025-12-13 08:40:00', 'R');

-- Parcours 18
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(18, '2025-12-12 08:30:00', '2025-12-12 09:00:00', 'A'),
(18, '2025-12-12 09:15:00', '2025-12-12 09:45:00', 'R'),
(18, '2025-12-13 08:45:00', '2025-12-13 09:15:00', 'A'),
(18, '2025-12-13 09:30:00', '2025-12-13 10:00:00', 'R');

-- Parcours 19
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(19, '2025-12-12 10:00:00', '2025-12-12 10:15:00', 'A'),
(19, '2025-12-12 10:30:00', '2025-12-12 10:45:00', 'R'),
(19, '2025-12-13 10:15:00', '2025-12-13 10:30:00', 'A'),
(19, '2025-12-13 10:45:00', '2025-12-13 11:00:00', 'R');

-- Parcours 20
INSERT INTO kptv_trajets (idParcours, date_debut, date_fin, type_voyage) VALUES
(20, '2025-12-12 09:30:00', '2025-12-12 09:52:00', 'A'),
(20, '2025-12-12 10:05:00', '2025-12-12 10:27:00', 'R'),
(20, '2025-12-13 09:45:00', '2025-12-13 10:07:00', 'A'),
(20, '2025-12-13 10:20:00', '2025-12-13 10:42:00', 'R');

-- Voyages (avec recette et carburant)
-- Trajets du parcours 1 (IDs 1-10)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(1, 1, 1, 65000.00, 18000.00),
(2, 1, 1, 58000.00, 16000.00),
(3, 1, 1, 72000.00, 19000.00),
(4, 1, 1, 61000.00, 17000.00),
(5, 1, 1, 68000.00, 18500.00),
(6, 1, 1, 55000.00, 16500.00),
(7, 2, 6, 70000.00, 19000.00),
(8, 2, 6, 63000.00, 17500.00),
(9, 2, 6, 75000.00, 20000.00),
(10, 2, 6, 59000.00, 16800.00);

-- Trajets du parcours 2 (IDs 11-16)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(11, 3, 2, 42000.00, 12000.00),
(12, 3, 2, 38000.00, 11000.00),
(13, 3, 2, 45000.00, 12500.00),
(14, 3, 2, 40000.00, 11500.00),
(15, 4, 7, 43000.00, 12200.00),
(16, 4, 7, 39000.00, 11300.00);

-- Trajets du parcours 3 (IDs 17-22)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(17, 5, 3, 32000.00, 9000.00),
(18, 5, 3, 28000.00, 8500.00),
(19, 5, 3, 35000.00, 9500.00),
(20, 5, 3, 30000.00, 8800.00),
(21, 6, 8, 33000.00, 9200.00),
(22, 6, 8, 29000.00, 8600.00);

-- Trajets du parcours 4 (IDs 23-26)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(23, 7, 4, 22000.00, 6500.00),
(24, 7, 4, 20000.00, 6000.00),
(25, 7, 4, 24000.00, 7000.00),
(26, 7, 4, 21000.00, 6300.00);

-- Trajets du parcours 5 (IDs 27-30)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(27, 8, 5, 18000.00, 5500.00),
(28, 8, 5, 16000.00, 5000.00),
(29, 8, 5, 19000.00, 5800.00),
(30, 8, 5, 17000.00, 5200.00);

-- Trajets du parcours 6 (IDs 31-34)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(31, 9, 9, 28000.00, 8000.00),
(32, 9, 9, 25000.00, 7500.00),
(33, 9, 9, 30000.00, 8500.00),
(34, 9, 9, 27000.00, 8000.00);

-- Trajets du parcours 7 (IDs 35-38)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(35, 10, 10, 38000.00, 11000.00),
(36, 10, 10, 35000.00, 10500.00),
(37, 10, 10, 40000.00, 11500.00),
(38, 10, 10, 36000.00, 10800.00);

-- Trajets du parcours 8 (IDs 39-42)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(39, 11, 11, 21000.00, 6200.00),
(40, 11, 11, 19000.00, 5800.00),
(41, 11, 11, 22000.00, 6500.00),
(42, 11, 11, 20000.00, 6000.00);

-- Trajets du parcours 9 (IDs 43-46)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(43, 12, 12, 17000.00, 5000.00),
(44, 12, 12, 15000.00, 4700.00),
(45, 12, 12, 18000.00, 5200.00),
(46, 12, 12, 16000.00, 4900.00);

-- Trajets du parcours 10 (IDs 47-50)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(47, 13, 13, 35000.00, 10000.00),
(48, 13, 13, 32000.00, 9500.00),
(49, 13, 13, 37000.00, 10500.00),
(50, 13, 13, 33000.00, 9800.00);

-- Trajets du parcours 11 (IDs 51-54)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(51, 14, 14, 48000.00, 13500.00),
(52, 14, 14, 44000.00, 12800.00),
(53, 14, 14, 50000.00, 14000.00),
(54, 14, 14, 45000.00, 13200.00);

-- Trajets du parcours 12 (IDs 55-58)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(55, 15, 15, 58000.00, 17000.00),
(56, 15, 15, 53000.00, 16000.00),
(57, 15, 15, 60000.00, 17500.00),
(58, 15, 15, 55000.00, 16500.00);

-- Trajets du parcours 13 (IDs 59-62)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(59, 1, 1, 72000.00, 21000.00),
(60, 1, 1, 68000.00, 20000.00),
(61, 1, 1, 75000.00, 22000.00),
(62, 1, 1, 70000.00, 20500.00);

-- Trajets du parcours 14 (IDs 63-66)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(63, 2, 6, 85000.00, 24000.00),
(64, 2, 6, 80000.00, 23000.00),
(65, 2, 6, 88000.00, 25000.00),
(66, 2, 6, 82000.00, 23500.00);

-- Trajets du parcours 15 (IDs 67-70)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(67, 3, 2, 55000.00, 16000.00),
(68, 3, 2, 51000.00, 15200.00),
(69, 3, 2, 57000.00, 16500.00),
(70, 3, 2, 52000.00, 15500.00);

-- Trajets du parcours 16 (IDs 71-74)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(71, 4, 7, 68000.00, 20000.00),
(72, 4, 7, 63000.00, 19000.00),
(73, 4, 7, 70000.00, 20500.00),
(74, 4, 7, 65000.00, 19500.00);

-- Trajets du parcours 17 (IDs 75-78)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(75, 5, 3, 88000.00, 25000.00),
(76, 5, 3, 83000.00, 24000.00),
(77, 5, 3, 90000.00, 26000.00),
(78, 5, 3, 85000.00, 24500.00);

-- Trajets du parcours 18 (IDs 79-82)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(79, 6, 8, 30000.00, 8800.00),
(80, 6, 8, 27000.00, 8300.00),
(81, 6, 8, 32000.00, 9200.00),
(82, 6, 8, 28000.00, 8500.00);

-- Trajets du parcours 19 (IDs 83-86)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(83, 7, 4, 14000.00, 4200.00),
(84, 7, 4, 12000.00, 3800.00),
(85, 7, 4, 15000.00, 4500.00),
(86, 7, 4, 13000.00, 4000.00);

-- Trajets du parcours 20 (IDs 87-90)
INSERT INTO kptv_voyage (idTrajet, idChauffeur, idVehicule, recette, carburant) VALUES
(87, 8, 5, 23000.00, 6800.00),
(88, 8, 5, 21000.00, 6300.00),
(89, 8, 5, 24000.00, 7000.00),
(90, 8, 5, 22000.00, 6500.00);

-- Pannes vehicules
INSERT INTO kptv_pannes (idVehicule, date_debut, date_fin, description) VALUES
(1, '2025-12-10 18:00:00', '2025-12-11 07:00:00', 'Vidange et remplacement des plaquettes'),
(3, '2025-12-12 13:30:00', '2025-12-12 17:45:00', 'Remplacement du pneu avant droit'),
(6, '2025-12-13 05:00:00', '2025-12-13 08:20:00', 'Contrôle circuit de freinage'),
(10, '2025-12-11 20:15:00', '2025-12-12 09:00:00', 'Révision périodique et changement filtre à air'),
(14, '2025-12-13 14:00:00', NULL, 'Panne moteur en cours de diagnostic');