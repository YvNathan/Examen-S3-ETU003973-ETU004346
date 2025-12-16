CREATE TABLE kptv_parcours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lieu_depart VARCHAR(255) NOT NULL,
    lieu_arrivee VARCHAR(255) NOT NULL,
    distance DECIMAL(10,2) NOT NULL
);

CREATE TABLE kptv_trajets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idParcours INT NOT NULL,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME,
    type_voyage CHAR(1) NOT NULL,
    FOREIGN KEY (idParcours) REFERENCES kptv_parcours(id),
    CONSTRAINT chk_dates CHECK (date_fin > date_debut)   
);

CREATE TABLE kptv_chauffeurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    contact VARCHAR(100)
);

CREATE TABLE kptv_vehicules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele VARCHAR(100),
    immatriculation VARCHAR(100) NOT NULL,
    capacite INT NOT NULL,
    min_versement DECIMAL(10,2) 
);

CREATE TABLE kptv_voyage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idTrajet INT NOT NULL,
    idChauffeur INT NOT NULL,
    idVehicule INT NOT NULL,
    recette DECIMAL(10,2) NOT NULL,
    carburant DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (idTrajet) REFERENCES kptv_trajets(id),
    FOREIGN KEY (idChauffeur) REFERENCES kptv_chauffeurs(id),
    FOREIGN KEY (idVehicule) REFERENCES kptv_vehicules(id)
);

CREATE OR REPLACE VIEW v_kptv_trajets_complets AS
SELECT 
    t.id AS trajet_id,
    t.date_debut,
    t.date_fin,
    t.type_voyage,
    vo.recette,
    vo.carburant,
    (vo.recette - vo.carburant) AS benefice,
    
    p.id AS parcours_id,
    p.lieu_depart,
    p.lieu_arrivee,
    p.distance,
    
    vo.id AS voyage_id,
    
    ve.id AS vehicule_id,
    ve.modele,
    ve.immatriculation,
    ve.capacite,
    ve.min_versement,
    
    c.id AS chauffeur_id,
    c.nom AS chauffeur_nom,
    c.contact AS chauffeur_contact
    
FROM kptv_trajets t
JOIN kptv_parcours p ON t.idParcours = p.id
JOIN kptv_voyage vo ON vo.idTrajet = t.id
JOIN kptv_vehicules ve ON vo.idVehicule = ve.id
JOIN kptv_chauffeurs c ON vo.idChauffeur = c.id;


CREATE OR REPLACE VIEW v_kptv_vehicules_par_jour AS
SELECT 
    DATE(date_debut) AS jour,
    vehicule_id,
    immatriculation,
    modele,
    chauffeur_id,
    chauffeur_nom,
    SUM(distance) AS km_effectues,
    SUM(recette) AS montant_recette,
    SUM(carburant) AS montant_carburant,
    SUM(benefice) AS benefice,
    COUNT(trajet_id) AS nombre_trajets
FROM v_kptv_trajets_complets
GROUP BY DATE(date_debut), vehicule_id, chauffeur_id;


CREATE OR REPLACE VIEW v_kptv_benefice_par_vehicule AS
SELECT 
    vehicule_id,
    immatriculation,
    modele,
    SUM(benefice) AS benefice_total,
    SUM(recette) AS recette_totale,
    SUM(carburant) AS carburant_total,
    SUM(distance) AS km_totaux,
    COUNT(trajet_id) AS nombre_trajets
FROM v_kptv_trajets_complets
GROUP BY vehicule_id;


CREATE OR REPLACE VIEW v_kptv_benefice_par_jour AS
SELECT 
    DATE(date_debut) AS jour,
    SUM(benefice) AS benefice_total,
    SUM(recette) AS recette_totale,
    SUM(carburant) AS carburant_total,
    SUM(distance) AS km_totaux,
    COUNT(trajet_id) AS nombre_trajets,
    COUNT(DISTINCT vehicule_id) AS nombre_vehicules,
    COUNT(DISTINCT chauffeur_id) AS nombre_chauffeurs
FROM v_kptv_trajets_complets
GROUP BY DATE(date_debut);

-- Trajets les plus rentables
CREATE OR REPLACE VIEW v_kptv_trajets_par_benefice AS
SELECT
    DATE(date_debut) AS jour,
    trajet_id,
    lieu_depart,
    lieu_arrivee,
    benefice
FROM v_kptv_trajets_complets t
WHERE benefice = (
    SELECT MAX(benefice)
    FROM v_kptv_trajets_complets
    WHERE DATE(date_debut) = DATE(t.date_debut)
);

-- Gestion des pannes
CREATE TABLE kptv_pannes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    idVehicule INT NOT NULL,
    date_debut DATETIME NOT NULL,
    date_fin DATETIME,
    description TEXT,
    FOREIGN KEY (idVehicule) REFERENCES kptv_vehicules(id),
    CONSTRAINT chk_panne_dates CHECK (date_fin IS NULL OR date_fin > date_debut)
);

--Salaire journalier
CREATE OR REPLACE VIEW v_salaire_journalier AS
SELECT
    DATE(t.date_debut) AS jour,
    c.id AS chauffeur_id,
    c.nom AS chauffeur_nom,
    SUM(CASE WHEN vo.recette >= ve.min_versement THEN vo.recette * 0.25 ELSE vo.recette * 0.08 END
    ) AS salaire_journalier
FROM kptv_voyage vo
JOIN kptv_trajets t ON vo.idTrajet = t.id
JOIN kptv_vehicules ve ON vo.idVehicule = ve.id
JOIN kptv_chauffeurs c ON vo.idChauffeur = c.id
GROUP BY DATE(t.date_debut), c.id, c.nom
ORDER BY jour, c.nom;





