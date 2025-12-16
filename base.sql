CREATE DATABASE examenS3;
USE examenS3;

CREATE TABLE lvr_vehicule(
    id INT PRIMARY KEY ,
    modele VARCHAR(50) ,
    immatriculation VARCHAR(20)
);

CREATE TABLE lvr_livreur (
    id INT PRIMARY KEY , 
    nom VARCHAR(50) ,
    contact VARCHAR(20)
    
);

CREATE TABLE lvr_statut (
    id INT PRIMARY KEY,
    descrip VARCHAR(50)
);


CREATE TABLE lvr_colis (
    id INT PRIMARY KEY,
    descrip VARCHAR(50),
    destinataire VARCHAR(50),
    poids_Kg DECIMAL(10,2)
);

CREATE TABLE lvr_confprix(
    id INT PRIMARY KEY,
    prix DECIMAL(10,2),
    actif BOOLEAN
);

CREATE TABLE lvr_affectation (
    id INT PRIMARY KEY,
    idvehicule INT, 
    idlivreur INT, 
    salaire_livreur DECIMAL(10,2),
    cout_vehicule DECIMAL(10,2),

    FOREIGN KEY (idvehicule) REFERENCES lvr_vehicule(id),
    FOREIGN KEY (idlivreur) REFERENCES lvr_livreur(id),

)

CREATE TABLE lvr_livraison (
    id INT PRIMARY KEY,
    idAffectation INT,
    idStatus INT,
    idColis INT ,
    adresseDepart VARCHAR(100),
    adresseDestination VARCHAR(100),
    date DATE,
    
    FOREIGN KEY (idAffectation) REFERENCES lvr_affectation(id),
    FOREIGN KEY (idStatus) REFERENCES lvr_statut(id),
    FOREIGN KEY (idColis) REFERENCES lvr_colis(id)
);