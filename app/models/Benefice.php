<?php

namespace app\models;

class Benefice
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getBeneficesDetailles()
    {
        $stmt = $this->db->query("SELECT * FROM v_lvr_benefices");
        return $stmt->fetchAll();
    }

    public function getBeneficesParPeriode($annee = null, $mois = null, $jour = null)
    {
        // Dès qu'il y a un jour → date complète
        if ($jour) {
            $conditions = [];
            $params = [];

            if ($annee) {
                $conditions[] = 'annee = ?';
                $params[] = $annee;
            }
            if ($mois) {
                $conditions[] = 'mois = ?';
                $params[] = $mois;
            }
            $conditions[] = 'jour = ?';
            $params[] = $jour;

            $sql = "
            SELECT *
            FROM v_lvr_benefices_date
            WHERE " . implode(' AND ', $conditions) . "
            ORDER BY date DESC
        ";

            return $this->execute($sql, $params);
        }

        // Année + mois
        if ($annee && $mois) {
            return $this->execute(
                "SELECT * FROM v_lvr_benefices_mois WHERE annee = ? AND mois = ?",
                [$annee, $mois]
            );
        }

        // Année seule
        if ($annee) {
            return $this->execute(
                "SELECT * FROM v_lvr_benefices_annee WHERE annee = ?",
                [$annee]
            );
        }

        // Défaut → dates complètes
        return $this->execute(
            "SELECT * FROM v_lvr_benefices_date ORDER BY date DESC"
        );
    }

    private function execute($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
