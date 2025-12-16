<?php

namespace app\models;

class Vehicules
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getVehicules()
    {
        $stmt = $this->db->query("SELECT * FROM Vehicule ORDER BY immatriculation");
        return $stmt->fetchAll();
    }

    public function getVehiculeById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Vehicule WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    private function getVehiculesPourUnJour($jour)
    {
        $sql = " SELECT jour, vehicule_id, immatriculation, modele,chauffeur_id, chauffeur_nom,km_effectues, montant_recette, montant_carburant,
               benefice, nombre_trajets
               FROM v_kptv_vehicules_par_jour
               WHERE jour = ?
               ORDER BY benefice DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jour]);
        return $stmt->fetchAll();
    }

    private function getVehiculesTousLesJours()
    {
        $sql = "SELECT jour, vehicule_id, immatriculation, modele,chauffeur_id, chauffeur_nom,km_effectues, montant_recette, montant_carburant,
                benefice, nombre_trajets
                FROM v_kptv_vehicules_par_jour
                ORDER BY jour DESC, benefice DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getVehiculesParJour($jour = null)
    {
        if ($jour !== null) {
            return $this->getVehiculesPourUnJour($jour);
        }
        return $this->getVehiculesTousLesJours();
    }
}
