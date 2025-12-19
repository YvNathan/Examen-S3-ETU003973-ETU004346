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
        if ($jour || (!$mois && !$annee)) {
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
            if ($jour) {
                $conditions[] = 'jour = ?';
                $params[] = $jour;
            }

            if (!empty($conditions)) {
                $sql = "SELECT * FROM v_lvr_benefices_periode WHERE " . implode(' AND ', $conditions);
                return $this->execute($sql, $params);
            }
            
            return $this->execute(
                "SELECT * FROM v_lvr_benefices_periode ORDER BY date DESC"
            );
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
            "SELECT * FROM v_lvr_benefices_periode ORDER BY date DESC"
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
            // Vérifier les différentes clés possibles pour la compatibilité
            $ca = $row['chiffreAffaires'] ?? $row['ca_total'] ?? 0;
            $coutLivreur = $row['coutLivreur'] ?? 0;
            $coutVehicule = $row['coutVehicule'] ?? 0;
            $coutTotal = $coutLivreur + $coutVehicule;
            
            $totaux['nb_livraisons']++;
            $totaux['ca_total'] += $ca;
            $totaux['cout_total'] += $coutTotal;
            $totaux['benefice'] += ($ca - $coutTotal);
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
