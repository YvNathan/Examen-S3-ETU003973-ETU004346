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
        // Année + Mois + Jour
        if ($annee && $mois && $jour) {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_jour_mois
                WHERE annee = ? AND jour = ?
                ORDER BY jour
            ";
            $params = [$annee, $jour];
        }
        // Année + Jour (sans mois)
        elseif ($annee && $jour) {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_jour_mois
                WHERE annee = ? AND jour = ?
                ORDER BY jour
            ";
            $params = [$annee, $jour];
        }
        // Année + Mois
        elseif ($annee && $mois) {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_mois
                WHERE annee = ? AND mois = ?
                ORDER BY annee DESC, mois DESC
            ";
            $params = [$annee, $mois];
        }
        // Année seule
        elseif ($annee) {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_annee
                WHERE annee = ?
                ORDER BY annee DESC
            ";
            $params = [$annee];
        }
        // Jour seul (toutes années)
        elseif ($jour) {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_jour_mois
                WHERE jour = ?
                ORDER BY annee DESC
            ";
            $params = [$jour];
        }
        // Par défaut : vue journalière complète
        else {
            $sql = "
                SELECT *
                FROM v_lvr_benefices_jour
                ORDER BY jour DESC
            ";
            $params = [];
        }

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
