<?php

namespace app\models;

class Salaire {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getSalaireJournalier() {
        $sql = 'SELECT jour, chauffeur_id, chauffeur_nom, salaire_journalier FROM v_salaire_journalier ORDER BY jour DESC, chauffeur_nom ASC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getSalaireJournalierAvecFiltre($jour = null, $chauffeurId = null) {
        if (empty($jour) && empty($chauffeurId)) {
            return $this->getSalaireJournalier();
        }
        
        $sql = 'SELECT jour, chauffeur_id, chauffeur_nom, salaire_journalier FROM v_salaire_journalier WHERE ';
        $params = [];
        
        if ($jour && $chauffeurId) {
            $sql .= 'jour = ? AND chauffeur_id = ?';
            $params = [$jour, $chauffeurId];
        } elseif ($jour) {
            $sql .= 'jour = ?';
            $params = [$jour];
        } else {
            $sql .= 'chauffeur_id = ?';
            $params = [$chauffeurId];
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getChauffeurs() {
        $stmt = $this->db->query('SELECT id, nom FROM kptv_chauffeurs ORDER BY nom');
        return $stmt->fetchAll();
    }
}
