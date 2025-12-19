<?php

namespace app\models;

class BeneficeVehicule
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getVehicules()
    {
        $stmt = $this->db->query("SELECT * FROM v_lvr_benefices_vehicules");
        return $stmt->fetchAll();
    }

    public function getDetails($idVehicule)
    {
        $stmt = $this->db->prepare("SELECT * FROM v_lvr_benefices_vehicules_details WHERE idVehicule = ?");
        $stmt->execute([$idVehicule]);
        return $stmt->fetchAll();
    }
}
