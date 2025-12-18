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

    public function getBeneficesParJour($v_jour = null)
    {
        if ($v_jour) {
            $sql = "SELECT * FROM v_lvr_benefices_jour 
                    WHERE jour = ? 
                    ORDER BY jour DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$v_jour]);
        } else {
            $stmt = $this->db->query("SELECT * FROM v_lvr_benefices_jour");
        }
        return $stmt->fetchAll();
    }

    public function getBeneficesParMois($annee = null, $mois = null)
    {
        $sql = "SELECT * FROM v_lvr_benefices_mois WHERE 1=1";
        $params = [];

        if ($annee) {
            $sql .= " AND annee = ?";
            $params[] = $annee;
        }

        if ($mois) {
            $sql .= " AND mois = ?";
            $params[] = $mois;
        }

        $sql .= " ORDER BY annee DESC, mois DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    public function getBeneficesParAnnee($annee = null)
    {
        $sql = "SELECT * FROM v_lvr_benefices_annee";
        $params = [];

        if ($annee) {
            $sql .= " WHERE annee = ?";
            $params[] = $annee;
        }

        $sql .= " ORDER BY annee DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
