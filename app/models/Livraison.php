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

    public function creer($idVehicule, $idLivreur, $coutVehicule, $coutLivreur, $idColis, $prixKg, $dateLivraison)
    {
        try {
            if ($coutVehicule < 0 || $coutLivreur < 0 || $prixKg < 0) {
                throw new Exception('Les montants ne peuvent pas être négatifs');
            }

            $check = $this->db->prepare('SELECT 1 FROM lvr_livraison WHERE idColis = ? LIMIT 1');
            $check->execute([$idColis]);
            if ($check->fetchColumn()) {
                throw new Exception('Le colis est déjà associé à une livraison');
            }

            $this->db->beginTransaction();

            $stmtA = $this->db->prepare('INSERT INTO lvr_affectation (idVehicule, idLivreur, coutVehicule, coutLivreur) VALUES (?, ?, ?, ?)');
            $stmtA->execute([$idVehicule, $idLivreur, $coutVehicule, $coutLivreur]);
            $idAffectation = (int) $this->db->lastInsertId();

            $stmtL = $this->db->prepare('INSERT INTO lvr_livraison (idAffectation, idColis, adresseDepart, dateLivraison, prixKg) VALUES (?, ?, ?, ?, ?)');
            $stmtL->execute([$idAffectation, $idColis, 'Entrepôt Central', $dateLivraison, $prixKg]);
            $idLivraison = (int) $this->db->lastInsertId();

            $exists = $this->db->prepare('SELECT COUNT(*) FROM lvr_livraisonStatut WHERE idLivraison = ?');
            $exists->execute([$idLivraison]);
            if ((int) $exists->fetchColumn() === 0) {
                $stmtS = $this->db->prepare('INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut) VALUES (?, ?, ?)');
                $stmtS->execute([$idLivraison, 1, $dateLivraison]);
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw new Exception('Erreur lors de la création de la livraison : ' . $e->getMessage());
        }
    }
}