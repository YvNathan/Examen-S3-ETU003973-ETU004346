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
        $stmt = $this->db->query("SELECT * FROM lvr_vehicule ORDER BY immatriculation");
        return $stmt->fetchAll();
    }

    public function getVehiculeById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM lvr_vehicule WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
