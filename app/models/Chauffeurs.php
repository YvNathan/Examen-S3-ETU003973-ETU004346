<?php
namespace app\models;

class Chauffeurs {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getChauffeurs() {
        $stmt = $this->db->query("SELECT * FROM Chauffeur ORDER BY nom, prenom");
        return $stmt->fetchAll();
    }
    
    public function getChauffeurById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Chauffeur WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}