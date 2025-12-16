<?php

namespace app\models;

use Flight;

class Parcours {
    private $db;

    public function __construct($db){
        $this->db = $db;
    }
    
    public function getParcours(){
        $stmt = $this->db->query("SELECT * FROM kptv_parcours");
        return $stmt->fetchAll();
    }

    public function getParcoursById($id){
        $stmt = $this->db->prepare("SELECT * FROM kptv_parcours WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
