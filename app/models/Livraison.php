<?php

namespace app\models;

use Exception;

class Livraison
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function creer($idVehicule, $idLivreur, $coutVehicule, $idColis, $prixKg, $dateLivraison)
    {
        try {
            $sql = "CALL p_creer_livraison_complete(?, ?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                $idVehicule,
                $idLivreur,
                $coutVehicule,
                $idColis,
                $prixKg,
                $dateLivraison
            ]);
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la livraison : " . $e->getMessage());
        }
    }
}