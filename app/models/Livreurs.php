<?php

namespace app\models;

class Livreurs
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getLivreurs()
    {
        $stmt = $this->db->query("SELECT * FROM lvr_livreur");
        return $stmt->fetchAll();
    }
}
