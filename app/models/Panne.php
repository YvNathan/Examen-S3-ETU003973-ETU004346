<?php

namespace app\models;

class Panne {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getPannes($idVehicule = null) {
        if ($idVehicule) {
            $sql = "SELECT p.id, p.idVehicule, p.date_debut, p.date_fin, p.description,
                           v.immatriculation, v.modele
                    FROM kptv_pannes p
                    JOIN kptv_vehicules v ON p.idVehicule = v.id
                    WHERE p.idVehicule = ?
                    ORDER BY p.date_debut DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idVehicule]);
            return $stmt->fetchAll();
        }

        $sql = "SELECT p.id, p.idVehicule, p.date_debut, p.date_fin, p.description,
                       v.immatriculation, v.modele
                FROM kptv_pannes p
                JOIN kptv_vehicules v ON p.idVehicule = v.id
                ORDER BY p.date_debut DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getPanneById($id) {
        $sql = "SELECT p.id, p.idVehicule, p.date_debut, p.date_fin, p.description,
                       v.immatriculation, v.modele
                FROM kptv_pannes p
                JOIN kptv_vehicules v ON p.idVehicule = v.id
                WHERE p.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getVehiculesUniques() {
        $sql = "SELECT DISTINCT p.idVehicule, v.immatriculation, v.modele
                FROM kptv_pannes p
                JOIN kptv_vehicules v ON p.idVehicule = v.id
                ORDER BY v.immatriculation";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
