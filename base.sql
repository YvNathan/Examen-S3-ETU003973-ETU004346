
DROP DATABASE IF EXISTS examenS3;
CREATE DATABASE examenS3;
USE examenS3;

-- Tables
CREATE TABLE lvr_zone (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50)
);

CREATE TABLE lvr_vehicule (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(50),
    immatriculation VARCHAR(20)
);

CREATE TABLE lvr_livreur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    contact VARCHAR(20),
    salaire DECIMAL(10,2)
);

CREATE TABLE lvr_statut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrip VARCHAR(100)
);

CREATE TABLE lvr_colis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descrip VARCHAR(100),
    destinataire VARCHAR(50),
    contact VARCHAR(50),
    poids_Kg DECIMAL(10,2),
    adrDestination VARCHAR(100),
    idZone INT NULL,
    FOREIGN KEY (idZone) REFERENCES lvr_zone(id)
);

CREATE TABLE lvr_affectation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idVehicule INT,
    idLivreur INT,
    coutVehicule DECIMAL(10,2),
    coutLivreur DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    FOREIGN KEY (idVehicule) REFERENCES lvr_vehicule(id),
    FOREIGN KEY (idLivreur) REFERENCES lvr_livreur(id)
);

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

CREATE TABLE lvr_livraisonStatut (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idLivraison INT,
    idStatut INT,
    dateStatut DATE,
    FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id),
    FOREIGN KEY (idStatut) REFERENCES lvr_statut(id)
);

CREATE TABLE lvr_paiement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prix DECIMAL(10,2),
    idLivraison INT,
    datePaiement DATE,
    FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id)
);

/* =========================
   Verif Colis dispo
========================= */
CREATE OR REPLACE VIEW v_lvr_colisDisponibles AS
SELECT *
FROM lvr_colis
WHERE id NOT IN (SELECT idColis FROM lvr_livraison WHERE idColis IS NOT NULL);

/* =========================
   Trigger 
========================= */
DELIMITER //
CREATE TRIGGER trg_lvr_new_livraison
AFTER INSERT ON lvr_livraison
FOR EACH ROW
BEGIN
    INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut)
    VALUES (NEW.id, 1, NEW.dateLivraison);
END//
DELIMITER ;

/* =========================
   Ajouter livraison
========================= */
DELIMITER //
CREATE OR REPLACE PROCEDURE p_lvr_new_livraison(
    IN p_idVehicule INT,
    IN p_idLivreur INT,
    IN p_coutVehicule DECIMAL(10,2),
    IN p_coutLivreur DECIMAL(10,2),
    IN p_idColis INT,
    IN p_prixKg DECIMAL(10,2),
    IN p_dateLivraison DATE
)
BEGIN
    DECLARE v_idAffectation INT;

    IF EXISTS (SELECT 1 FROM lvr_livraison WHERE idColis = p_idColis) THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le colis est déjà associé à une livraison.';
    END IF;

    INSERT INTO lvr_affectation (idVehicule, idLivreur, coutVehicule, coutLivreur)
    VALUES (p_idVehicule, p_idLivreur, p_coutVehicule, p_coutLivreur);

    SET v_idAffectation = LAST_INSERT_ID();

    INSERT INTO lvr_livraison (idAffectation, idColis, adresseDepart, dateLivraison, prixKg)
    VALUES (v_idAffectation, p_idColis, 'Entrepôt Central', p_dateLivraison, p_prixKg);
END//
DELIMITER ;

/* =========================
   Confirmer livraison 
========================= */
DELIMITER //
CREATE OR REPLACE PROCEDURE p_gestion_statut (
    IN p_idLivraison INT,
    IN p_datePaiement DATE
)
BEGIN
    DECLARE current_statut INT DEFAULT NULL;
    DECLARE prixKg DECIMAL(10,2);
    DECLARE poids_Kg DECIMAL(10,2);
    DECLARE prixTotal DECIMAL(10,2);

    -- Récupérer le statut actuel
    SELECT s.id INTO current_statut
    FROM lvr_livraisonStatut ls
    JOIN lvr_statut s ON s.id = ls.idStatut
    WHERE ls.idLivraison = p_idLivraison
    ORDER BY ls.dateStatut DESC
    LIMIT 1;

    IF current_statut = 2 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Livraison déjà marquée comme livrée.';
    ELSEIF current_statut = 3 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Livraison annulée, impossible de confirmer.';
    END IF;

    -- Calcul du paiement
    SELECT l.prixKg, c.poids_Kg INTO prixKg, poids_Kg
    FROM lvr_livraison l
    JOIN lvr_colis c ON c.id = l.idColis
    WHERE l.id = p_idLivraison;

    SET prixTotal = prixKg * poids_Kg;

    INSERT INTO lvr_paiement (idLivraison, prix, datePaiement)
    VALUES (p_idLivraison, prixTotal, p_datePaiement);

    -- Nouveau statut : livré
    INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut)
    VALUES (p_idLivraison, 2, p_datePaiement);
END//
DELIMITER ;

/* =========================
  Annuler livraison
========================= */
DELIMITER //
CREATE OR REPLACE PROCEDURE p_annuler_livraison (
    IN p_idLivraison INT
)
BEGIN
    INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut)
    VALUES (p_idLivraison, 3, NOW());
END//
DELIMITER ;

/* =========================
   BÉNÉFICES Global
========================= */
CREATE OR REPLACE VIEW v_lvr_benefices AS
SELECT
    l.id AS idLivraison,
    l.dateLivraison,
    c.descrip AS colis,
    c.poids_Kg,
    l.prixKg,
    a.coutLivreur,
    a.coutVehicule,
    p.prix AS chiffreAffaires,
    p.datePaiement,
    s.descrip AS statut,
    lv.nom AS livreur,
    v.immatriculation AS vehicule,
    z.nom AS zone_livraison
FROM lvr_livraison l
JOIN lvr_colis c ON c.id = l.idColis
LEFT JOIN lvr_zone z ON z.id = c.idZone
JOIN lvr_affectation a ON a.id = l.idAffectation
JOIN lvr_livreur lv ON lv.id = a.idLivreur
JOIN lvr_vehicule v ON v.id = a.idVehicule
LEFT JOIN lvr_paiement p ON p.idLivraison = l.id
JOIN lvr_livraisonStatut ls ON ls.idLivraison = l.id
    AND ls.dateStatut = (SELECT MAX(dateStatut) FROM lvr_livraisonStatut ls2 WHERE ls2.idLivraison = l.id)
JOIN lvr_statut s ON s.id = ls.idStatut
WHERE ls.idStatut IN (2, 3);



/* =========================
   BÉNÉFICES PAR Jour
========================= */
CREATE OR REPLACE VIEW v_lvr_benefices_jour AS
SELECT
    DATE(dateLivraison) AS jour,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + coutVehicule) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + coutVehicule) AS benefice
FROM v_lvr_benefices
GROUP BY jour
ORDER BY jour DESC;


/* =========================
   BÉNÉFICES PAR MOIS
========================= */
CREATE OR REPLACE VIEW v_lvr_benefices_mois AS
SELECT
    YEAR(dateLivraison) AS annee,
    MONTH(dateLivraison) AS mois,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + coutVehicule) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + coutVehicule) AS benefice
FROM v_lvr_benefices
GROUP BY annee, mois
ORDER BY annee DESC, mois DESC;


/* =========================
   BÉNÉFICES PAR ANNÉE
========================= */
CREATE OR REPLACE VIEW v_lvr_benefices_annee AS
SELECT
    YEAR(dateLivraison) AS annee,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + coutVehicule) AS cout_total,
    SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + coutVehicule) AS benefice
FROM v_lvr_benefices
GROUP BY annee
ORDER BY annee DESC;


/* =========================
   BÉNÉFICES PAR date
========================= */
CREATE OR REPLACE VIEW v_lvr_benefices_date AS
SELECT
    DATE(dateLivraison) AS date,
    YEAR(dateLivraison) AS annee,
    MONTH(dateLivraison) AS mois,
    DAY(dateLivraison) AS jour,
    COUNT(*) AS nb_livraisons,
    SUM(IFNULL(chiffreAffaires, 0)) AS ca_total,
    SUM(coutLivreur + coutVehicule) AS cout_total,
    (SUM(IFNULL(chiffreAffaires, 0)) - SUM(coutLivreur + coutVehicule)) AS benefice
FROM v_lvr_benefices
GROUP BY DATE(dateLivraison);




/* =========================
   STATUT ACTUEL DES LIVRAISONS
========================= */
CREATE OR REPLACE VIEW v_getStatusLivraison AS
SELECT
    l.id AS idLivraison,
    c.descrip AS colis,
    ls.dateStatut,
    c.adrDestination,
    z.nom AS zone,
    s.descrip AS statut
FROM lvr_livraisonStatut ls
JOIN lvr_statut s ON ls.idStatut = s.id
JOIN lvr_livraison l ON ls.idLivraison = l.id
JOIN lvr_colis c ON l.idColis = c.id
LEFT JOIN lvr_zone z ON z.id = c.idZone
WHERE ls.dateStatut = (
    SELECT MAX(ls2.dateStatut)
    FROM lvr_livraisonStatut ls2
    WHERE ls2.idLivraison = l.id
);