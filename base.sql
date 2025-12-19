DROP DATABASE IF EXISTS examenS3;
CREATE DATABASE examenS3;
USE examenS3;

-- 1. Table des zones de livraison
CREATE TABLE lvr_zone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    pourcentage DECIMAL(10,2)
);

-- 2. Table des véhicules
CREATE TABLE lvr_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(50),
    immatriculation VARCHAR(20)
);

-- 3. Table des livreurs
CREATE TABLE lvr_livreur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    contact VARCHAR(20),
    salaire DECIMAL(10,2)
);

-- 4. Table des statuts
CREATE TABLE lvr_statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrip VARCHAR(100)
);

-- 5. Table des affectations (véhicule + livreur + zone)
CREATE TABLE lvr_affectation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idVehicule INT,
    idLivreur INT,
    coutVehicule DECIMAL(10,2),
    coutLivreur DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    idZone INT NULL,
    FOREIGN KEY (idVehicule) REFERENCES lvr_vehicule(id),
    FOREIGN KEY (idLivreur) REFERENCES lvr_livreur(id),
    FOREIGN KEY (idZone) REFERENCES lvr_zone(id)
);

-- 6. Table des colis
CREATE TABLE lvr_colis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrip VARCHAR(100),
    destinataire VARCHAR(50),
    contact VARCHAR(50),
    poids_Kg DECIMAL(10,2),
    adrDestination VARCHAR(100)
);

-- 7. Table des livraisons
CREATE TABLE lvr_livraison (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idAffectation INT,
    idColis INT,
    adresseDepart VARCHAR(100),
    dateLivraison DATE,
    prixKg DECIMAL(10,2),
    FOREIGN KEY (idAffectation) REFERENCES lvr_affectation(id),
    FOREIGN KEY (idColis) REFERENCES lvr_colis(id)
);

-- 8. Table des statuts de livraison
CREATE TABLE lvr_livraisonStatut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idLivraison INT,
    idStatut INT,
    dateStatut DATE,
    FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id),
    FOREIGN KEY (idStatut) REFERENCES lvr_statut(id)
);

-- 9. Table des paiements
CREATE TABLE lvr_paiement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2),
    idLivraison INT,
    datePaiement DATE,
    FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id)
);

-- Colis disponibles (pas encore affectés à une livraison)
CREATE OR REPLACE VIEW v_lvr_colisDisponibles AS
SELECT *
FROM lvr_colis
WHERE id NOT IN (SELECT idColis FROM lvr_livraison WHERE idColis IS NOT NULL);

-- Vue bénéfices (livraisons terminées/annulées)
    CREATE OR REPLACE VIEW v_lvr_benefices AS
    SELECT
        l.id AS idLivraison,
        l.dateLivraison,
        c.descrip AS colis,
        c.poids_Kg,
        l.prixKg,
        l.prixKg * c.poids_Kg * (1 + COALESCE(z.pourcentage, 0)/100) AS prixLivraisonAvecSupplement,
        a.coutLivreur,
        a.coutVehicule,
        p.prix AS chiffreAffaires,
        p.datePaiement,
        s.descrip AS statut,
        lv.nom AS livreur,
        v.immatriculation AS vehicule,
        z.nom AS zone_livraison,
        z.pourcentage AS supplement_pourcentage
    FROM lvr_livraison l
    JOIN lvr_colis c ON c.id = l.idColis
    JOIN lvr_affectation a ON a.id = l.idAffectation
    LEFT JOIN lvr_zone z ON z.id = a.idZone
    JOIN lvr_livreur lv ON lv.id = a.idLivreur
    JOIN lvr_vehicule v ON v.id = a.idVehicule
    LEFT JOIN lvr_paiement p ON p.idLivraison = l.id
    JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
        AND ls.dateStatut = (SELECT MAX(dateStatut) FROM lvr_livraisonStatut ls2 WHERE ls2.idLivraison = l.id)
    JOIN lvr_statut s ON s.id = ls.idStatut
    WHERE ls.idStatut IN (2, 3); 


-- bénéfices par jour
CREATE OR REPLACE VIEW v_lvr_benefices_jour AS
SELECT
    DATE(dateLivraison) AS jour,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS benefice
FROM v_lvr_benefices
GROUP BY jour
ORDER BY jour DESC;

-- Bénéfices par mois
CREATE OR REPLACE VIEW v_lvr_benefices_mois AS
SELECT
    YEAR(dateLivraison) AS annee,
    MONTH(dateLivraison) AS mois,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS benefice
FROM v_lvr_benefices
GROUP BY annee, mois
ORDER BY annee DESC, mois DESC;

-- Bénéfices par année
CREATE OR REPLACE VIEW v_lvr_benefices_annee AS
SELECT
    YEAR(dateLivraison) AS annee,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS benefice
FROM v_lvr_benefices
GROUP BY annee
ORDER BY annee DESC;

-- Benefices par période
CREATE OR REPLACE VIEW v_lvr_benefices_periode AS
SELECT
    DATE(dateLivraison) AS date,
    YEAR(dateLivraison) AS annee,
    MONTH(dateLivraison) AS mois,
    DAY(dateLivraison) AS jour,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + COALESCE(coutVehicule, 0)) AS benefice
FROM v_lvr_benefices
GROUP BY date, annee, mois, jour
ORDER BY date DESC;

-- Statut actuel des livraisons (corrigé)
CREATE OR REPLACE VIEW v_getStatusLivraison AS
SELECT
    l.id AS idLivraison,
    c.descrip AS colis,
    ls.dateStatut,
    c.adrDestination,
    COALESCE(z.nom, 'Non définie') AS zone,
    s.descrip AS statut
FROM lvr_livraison l
JOIN lvr_colis c ON l.idColis = c.id
JOIN lvr_affectation a ON a.id = l.idAffectation
LEFT JOIN lvr_zone z ON z.id = a.idZone
JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
JOIN lvr_statut s ON s.id = ls.idStatut
WHERE ls.id = (
    SELECT ls2.id
    FROM lvr_livraisonStatut ls2
    WHERE ls2.idLivraison = l.id
    ORDER BY ls2.dateStatut DESC, ls2.id DESC
    LIMIT 1
);

-- Vue avec détails par véhicule (chaque livraison)
CREATE OR REPLACE VIEW v_lvr_benefices_vehicule_details AS
SELECT
    v.id AS idVehicule,
    v.modele,
    v.immatriculation,
    l.id AS idLivraison,
    l.dateLivraison,
    c.descrip AS colis,
    c.poids_Kg,
    l.prixKg,
    l.prixKg * c.poids_Kg * (1 + COALESCE(z.pourcentage, 0)/100) AS prixLivraisonAvecSupplement,
    a.coutVehicule,
    a.coutLivreur,
    p.prix AS chiffreAffaires,
    p.datePaiement,
    (a.coutVehicule + a.coutLivreur) AS coutTotal,
    IFNULL(p.prix, 0) - (a.coutVehicule + a.coutLivreur) AS benefice,
    s.descrip AS statut,
    lv.nom AS livreur,
    z.nom AS zone_livraison
FROM lvr_vehicule v
JOIN lvr_affectation a ON a.idVehicule = v.id
JOIN lvr_livraison l ON l.idAffectation = a.id
JOIN lvr_colis c ON c.id = l.idColis
LEFT JOIN lvr_zone z ON z.id = a.idZone
JOIN lvr_livreur lv ON lv.id = a.idLivreur
LEFT JOIN lvr_paiement p ON p.idLivraison = l.id
JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
    AND ls.dateStatut = (SELECT MAX(dateStatut) FROM lvr_livraisonStatut ls2 WHERE ls2.idLivraison = l.id)
JOIN lvr_statut s ON s.id = ls.idStatut
WHERE ls.idStatut IN (2, 3);

-- Vue agrégée par véhicule
CREATE OR REPLACE VIEW v_lvr_benefices_vehicules AS
SELECT
    v.id AS idVehicule,
    v.modele,
    v.immatriculation,
    COUNT(l.id) AS nb_livraisons,
    SUM(IFNULL(p.prix, 0)) AS chiffreAffaires,
    SUM(a.coutVehicule + a.coutLivreur) AS coutRevient,
    SUM(IFNULL(p.prix, 0)) - SUM(a.coutVehicule + a.coutLivreur) AS benefice,
    MIN(l.dateLivraison) AS premiere_livraison,
    MAX(l.dateLivraison) AS derniere_livraison
FROM lvr_vehicule v
LEFT JOIN lvr_affectation a ON a.idVehicule = v.id
LEFT JOIN lvr_livraison l ON l.idAffectation = a.id
LEFT JOIN lvr_colis c ON c.id = l.idColis
LEFT JOIN lvr_paiement p ON p.idLivraison = l.id
LEFT JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
    AND ls.dateStatut = (SELECT MAX(dateStatut) FROM lvr_livraisonStatut ls2 WHERE ls2.idLivraison = l.id)
WHERE ls.idStatut IN (2, 3) OR l.id IS NULL
GROUP BY v.id, v.modele, v.immatriculation
ORDER BY benefice DESC;

-- Vue de détails par véhicule
CREATE OR REPLACE VIEW v_lvr_benefices_vehicules_details AS
SELECT
    v.id AS idVehicule,
    v.modele,
    v.immatriculation,
    l.id AS idLivraison,
    l.dateLivraison,
    c.descrip AS colis,
    c.poids_Kg,
    l.prixKg,
    z.nom AS zone_livraison,
    z.pourcentage AS supplement_pourcentage,
    a.coutVehicule,
    a.coutLivreur,
    p.prix AS chiffreAffaires,
    p.datePaiement,
    s.descrip AS statut,
    lv.nom AS livreur
FROM lvr_vehicule v
JOIN lvr_affectation a ON a.idVehicule = v.id
JOIN lvr_livraison l ON l.idAffectation = a.id
JOIN lvr_colis c ON c.id = l.idColis
LEFT JOIN lvr_zone z ON z.id = a.idZone
LEFT JOIN lvr_paiement p ON p.idLivraison = l.id
JOIN lvr_livreur lv ON lv.id = a.idLivreur
JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
    AND ls.dateStatut = (SELECT MAX(dateStatut) FROM lvr_livraisonStatut ls2 WHERE ls2.idLivraison = l.id)
JOIN lvr_statut s ON s.id = ls.idStatut
WHERE ls.idStatut IN (2, 3);