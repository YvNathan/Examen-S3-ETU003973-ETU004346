<?php

namespace app\models;

use Flight;

class Trajets {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function getParcours($id){
        $stmt = $this->db->prepare("SELECT * FROM kptv_parcours WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getTrajetsByParcours($id){
        $stmt = $this->db->prepare("SELECT * FROM v_kptv_trajets_complets WHERE parcours_id = ? ORDER BY date_debut DESC");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }

    public function getTrajetsLesPlusRentablesPourJour($jour){
        $sql = "SELECT DATE(date_debut) AS jour, trajet_id, lieu_depart, lieu_arrivee,(recette - carburant) AS benefice
                FROM v_kptv_trajets_complets WHERE DATE(date_debut) = ? ORDER BY benefice DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$jour]);
        return $stmt->fetchAll();
    }

    public function getTrajetsLesPlusRentablesTousLesJours(){
        $sql = "SELECT DATE(t.date_debut) AS jour, t.trajet_id, t.lieu_depart, t.lieu_arrivee,(t.recette - t.carburant) AS benefice
                FROM v_kptv_trajets_complets t WHERE (t.recette - t.carburant) = ( SELECT MAX(tt.recette - tt.carburant) 
                FROM v_kptv_trajets_complets tt WHERE DATE(tt.date_debut) = DATE(t.date_debut))
                ORDER BY jour DESC, benefice DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getTrajetsLesPlusRentablesParJour($jour = null){
        if ($jour) {
            return $this->getTrajetsLesPlusRentablesPourJour($jour);
        }

        return $this->getTrajetsLesPlusRentablesTousLesJours();
    }
}
