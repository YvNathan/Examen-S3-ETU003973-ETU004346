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