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
            FROM v_lvr_benefices_jour
            WHERE " . implode(' AND ', $conditions) . "
            ORDER BY date DESC
        ";

            return $this->execute($sql, $params);
        }

        if ($annee && $mois) {
            return $this->execute(
                "SELECT * FROM v_lvr_benefices_mois WHERE annee = ? AND mois = ?",
                [$annee, $mois]
            );
        }

        if ($annee) {
            return $this->execute(
                "SELECT * FROM v_lvr_benefices_annee WHERE annee = ?",
                [$annee]
            );
        }

        return $this->execute(
            "SELECT * FROM v_lvr_benefices_jour ORDER BY date DESC"
        );
    }

    public function calculerTotaux($benefices)
    {
        $totaux = [
            'nb_livraisons' => 0,
            'ca_total' => 0,
            'cout_total' => 0,
            'benefice' => 0
        ];

        if (empty($benefices)) {
            return $totaux;
        }

        foreach ($benefices as $row) {
            $totaux['nb_livraisons'] += $row['nb_livraisons'] ?? 0;
            $totaux['ca_total'] += $row['ca_total'] ?? 0;
            $totaux['cout_total'] += $row['cout_total'] ?? 0;
            $totaux['benefice'] += $row['benefice'] ?? 0;
        }

        return $totaux;
    }

    private function execute($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}