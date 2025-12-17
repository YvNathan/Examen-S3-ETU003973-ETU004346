CREATE DATABASE examenS3;
USE examenS3;

CREATE TABLE lvr_zone(
     id SERIAL PRIMARY KEY,
     nom VARCHAR(50)
)

CREATE TABLE lvr_vehicule(
    id SERIAL PRIMARY KEY,
    modele VARCHAR(50),
    immatriculation VARCHAR(20)
);

CREATE TABLE lvr_livreur (
    id SERIAL PRIMARY KEY, 
    nom VARCHAR(100),
    contact VARCHAR(20),
    salaire DECIMAL(10,2)
    
);

CREATE TABLE lvr_statut (
    id SERIAL PRIMARY KEY,
    descrip VARCHAR(100)
);


CREATE TABLE lvr_colis (
    id SERIAL PRIMARY KEY,
    descrip VARCHAR(100),
    destinataire VARCHAR(50),
    contact VARCHAR(50),
    poids_Kg DECIMAL(10,2),
    adrDestination VARCHAR(100)
);


CREATE TABLE lvr_affectation (
    id SERIAL PRIMARY KEY,
    idVehicule INT, 
    idLivreur INT, 
    coutVehicule DECIMAL(10,2),

    FOREIGN KEY (idvehicule) REFERENCES lvr_vehicule(id),
    FOREIGN KEY (idlivreur) REFERENCES lvr_livreur(id)

)

CREATE TABLE lvr_livraison (
    id SERIAL PRIMARY KEY,
    idAffectation INT,
    idColis INT ,
    adresseDepart VARCHAR(100),
    dateLivraison DATE,
    prixKg DECIMAL(10,2),
    
    FOREIGN KEY (idAffectation) REFERENCES lvr_affectation(id),
    FOREIGN KEY (idColis) REFERENCES lvr_colis(id)
);

CREATE TABLE lvr_livraisonStatut(
     id SERIAL PRIMARY KEY,
     idLivraison INT,
     idStatut INT,
     dateStatut DATE, 

     FOREIGN KEY (idLivraison) REFERENCES lvr_livraison(id),
     FOREIGN KEY (idStatut) REFERENCES lvr_statut(id)

)

CREATE TABLE lvr_paiement(
     id SERIAL PRIMARY KEY,
     prix DECIMAL(10,2),
     idLivraison INT,
     datePaiement DATE,

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

---Trigger insertion nouveau statut au moment de la création d'une nouvelle livraison--
CREATE OR REPLACE FUNCTION fn_lvr_new_livraison_statut()
RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO lvr_livraisonStatut (IdLivraison, IdStatut, DateStatut)
    VALUES (NEW.id, 1, NEW.dateLivraison); 
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_lvr_new_livraison
AFTER INSERT ON lvr_livraison
FOR EACH ROW
EXECUTE FUNCTION fn_lvr_new_livraison_statut();

---Procedure pour engendrer une livraison--
CREATE OR REPLACE PROCEDURE p_lvr_new_livraison(
    p_idVehicule INT,
    p_idLivreur INT,
    p_coutVehicule DECIMAL,
    p_idColis INT,
    p_prixKg DECIMAL,
    p_dateLivraison DATE
)
LANGUAGE plpgsql
AS $$
DECLARE
    v_idAffectation INT;
BEGIN
    --verification de la disponibilite du colis
    IF EXISTS (SELECT 1 FROM lvr_livraison WHERE idColis = p_idColis) THEN
        RAISE EXCEPTION 'Le colis % est déjà associé à une livraison.', p_idColis;
    END IF;

    --verification des montants
    IF p_coutVehicule < 0 OR p_prixKg < 0 THEN
        RAISE EXCEPTION 'Les montants ne peuvent pas être négatifs.';
    END IF;

    --insert affectation
    INSERT INTO lvr_affectation (idVehicule, idLivreur, coutVehicule)
    VALUES (p_idVehicule, p_idLivreur, p_coutVehicule)
    RETURNING id INTO v_idAffectation;

    --insert new livraison
    INSERT INTO lvr_livraison (idAffectation, idColis, adresseDepart, dateLivraison, prixKg)
    VALUES (v_idAffectation, p_idColis, 'Entrepôt Central', p_dateLivraison, p_prixKg);

    EXCEPTION
        WHEN OTHERS THEN
            RAISE NOTICE 'Erreur lors de la création de la livraison : %', SQLERRM;
        ROLLBACK;
        RAISE;

    RAISE NOTICE 'Nouvelle livraison créé pour le colis %', p_idColis;


END;
$$;


---Liste des colis disponibles
CREATE OR REPLACE VIEW v_lvr_colisDisponibles AS
SELECT * FROM Colis 
WHERE id NOT IN (SELECT idColis FROM Livraison);



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
    INSERT INTO lvr_paiement (idLivraison, prix, datePaiement)
    VALUES (p_idLivraison, prixTotal, p_datePaiement);

    -- Mise à jour du statut
    UPDATE lvr_livraisonStatut
    SET idStatut = 2,
        dateStatut = p_datePaiement
    WHERE idLivraison = p_idLivraison;

END;
$$;




  
  
