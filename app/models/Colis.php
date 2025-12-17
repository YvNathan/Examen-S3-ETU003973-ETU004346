<?php

namespace app\models;

class Colis
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getColisDisponibles()
    {
        $stmt = $this->db->query("SELECT * FROM v_lvr_colisDisponibles");
        return $stmt->fetchAll();
    }
}
