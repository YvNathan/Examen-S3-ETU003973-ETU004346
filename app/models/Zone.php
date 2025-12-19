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
        $stmt = $this->db->query("SELECT * FROM lvr_zone ORDER BY nom");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getZoneById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM lvr_zone WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);  // Retourne false si pas trouvé
    }

    public function add($nom, $pourcentage)
    {
        $stmt = $this->db->prepare("INSERT INTO lvr_zone (nom, pourcentage) VALUES (?, ?)");
        $stmt->execute([$nom, $pourcentage]);
        return $this->db->lastInsertId();
    }

    public function update($id, $nom, $pourcentage)
    {
        $stmt = $this->db->prepare("UPDATE lvr_zone SET nom = ?, pourcentage = ? WHERE id = ?");
        return $stmt->execute([$nom, $pourcentage, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM lvr_zone WHERE id = ?");
        return $stmt->execute([$id]);
    }
}