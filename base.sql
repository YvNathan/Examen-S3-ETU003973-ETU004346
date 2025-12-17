CREATE DATABASE examenS3;
USE examenS3;

CREATE TABLE lvr_zone(
     id INT PRIMARY KEY ,
     nom VARCHAR(50)
)

CREATE TABLE lvr_vehicule(
    id INT PRIMARY KEY ,
    modele VARCHAR(50) ,
    immatriculation VARCHAR(20)
);

CREATE TABLE lvr_livreur (
    id INT PRIMARY KEY , 
    nom VARCHAR(100) ,
    contact VARCHAR(20),
    salaire DECIMAL(10,2)
    
);

CREATE TABLE lvr_statut (
    id INT PRIMARY KEY,
    descrip VARCHAR(100)
);


CREATE TABLE lvr_colis (
    id INT PRIMARY KEY,
    descrip VARCHAR(100),
    destinataire VARCHAR(50),
    contact VARCHAR(50),
    poids_Kg DECIMAL(10,2)
    adrDestination VARCHAR(100), 
    idZone INT,

    FOREIGN KEY (idZone) REFERENCES lvr_zone(id)
);


CREATE TABLE lvr_affectation (
    id INT PRIMARY KEY,
    idVehicule INT, 
    idLivreur INT, 
    coutVehicule DECIMAL(10,2),

    FOREIGN KEY (idvehicule) REFERENCES lvr_vehicule(id),
    FOREIGN KEY (idlivreur) REFERENCES lvr_livreur(id)

)

CREATE TABLE lvr_livraison (
    id INT PRIMARY KEY,
    idAffectation INT,
    idColis INT ,
    adresseDepart VARCHAR(100),
    date DATE,
    prixKg DECIMAL(10,2),
    
    FOREIGN KEY (idAffectation) REFERENCES lvr_affectation(id),
    FOREIGN KEY (idColis) REFERENCES lvr_colis(id)
);

CREATE TABLE lvr_livraisonStatut(
     id INT PRIMARY KEY,
     idLivraison INT,
     idStatut INT,
     dateStatut DATE, 

     FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id),
     FOREIGN KEY (idStatut) REFERENCES lvr_statut(id)

)

CREATE TABLE lvr_paiement(
     id INT PRIMARY KEY,
     prix DECIMAL(10,2),
     idLivraison INT,
     date DATE,

     FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id)
)

---selection de tout les statut de livraison---
CREATE OR REPLACE VIEW v_getStatusLivraison AS
SELECT 
    c.descrip,
    ls.dateStatut,
    c.adrDestination,
    s.descrip AS statut
FROM lvr_livraisonStatut ls
JOIN lvr_statut s      ON ls.idStatut = s.id
JOIN lvr_livraison l    ON ls.idLivraison = l.id
JOIN lvr_colis c        ON l.idColis = c.id;


---Procedure pour la confirmation de livraison--
CREATE OR REPLACE PROCEDURE p_gestion_statut (
    p_idLivraison INT,
    p_datePaiement DATE
)
LANGUAGE plpgsql
AS $$
DECLARE
    prixKg    DECIMAL(10,2);
    poids_Kg  DECIMAL(10,2);
    prixTotal DECIMAL(10,2);
BEGIN
    --Verifie que Livraison est en attente pour ce livraison 
    IF NOT EXISTS (
        SELECT 1
        FROM lvr_livraisonStatut
        WHERE idLivraison = p_idLivraison
          AND idStatut = 1
    ) THEN
        RAISE EXCEPTION 'Livraison % inexistante ou non en cours', p_idLivraison;
    END IF;

    -- Récup des données de livraison
    SELECT l.prixKg, c.poids_Kg
    INTO prixKg, poids_Kg
    FROM lvr_livraison l
    JOIN lvr_colis c ON c.id = l.idColis
    WHERE l.id = p_idLivraison;

    IF NOT FOUND THEN
        RAISE EXCEPTION 'Données manquantes pour la livraison %', p_idLivraison;
    END IF;

    -- Calcul du prix total
    prixTotal := prixKg * poids_Kg;

    -- Insert dans paiement
    INSERT INTO lvr_paiement (idLivraison, prix, date)
    VALUES (p_idLivraison, prixTotal, p_datePaiement);

    -- Mise à jour du statut
    UPDATE lvr_livraisonStatut
    SET idStatut = 2,
        dateStatut = p_datePaiement
    WHERE idLivraison = p_idLivraison;

END;
$$;




  
  
