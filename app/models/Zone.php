<?php

namespace app\models;

class Zone
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getZones()
    {
        $stmt = $this->db->query("SELECT * FROM lvr_zone");
        return $stmt->fetchAll();
    }

    public function getZoneById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM lvr_zone WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
