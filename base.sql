CREATE DATABASE examenS3;
USE examenS3;

CREATE TABLE lvr_Vehicule(
    id INT PRIMARY KEY ,
    modele VARCHAR(50) ,
    immatriculation VARCHAR(20)
);

CREATE TABLE lvr_Livreur (
    id INT PRIMARY KEY , 
    nom VARCHAR(50) ,
    salairejournalier DECIMAL(10,2),
    contact VARCHAR(20)
)

CREATE TABLE lvr_Status (
    id INT PRIMARY KEY,
    description VARCHAR(50)
)

CREATE TABLE lvr_Colis (
    id INT PRIMARY KEY,
    description VARCHAR(50),
    poidsKg DECIMAL(10,2)
)

CREATE TABLE lvr_Confprix(
    id INT PRIMARY KEY,
    prix DECIMAL(10,2),
    actif BOOLEAN
)

CREATE TABLE lvr_Livraison (
    id INT PRIMARY KEY,
    idVehicule INT, 
    idLivreur INT ,
    idStatus INT,
    idColis INT ,
    adresseDepart VARCHAR(100),
    adresseDestination VARCHAR(100),
    date DATE,
    
    FOREIGN KEY (idVehicule) REFERENCES lvr_Vehicule(id),
    FOREIGN KEY (idLivreur) REFERENCES lvr_Livreur(id),
    FOREIGN KEY (idStatus) REFERENCES lvr_Status(id),
    FOREIGN KEY (idColis) REFERENCES lvr_Colis(id)
)