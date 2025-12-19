<?php

namespace app\models;

class Statut
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getLivraisonStatut()
    { 
      $stmt = $this->db->query("SELECT * FROM v_getStatusLivraison ");
        return $stmt->fetchAll();
    }

    public function acheverLivraison($idLivraison, $datePaiement)
    {
      $currentStmt = $this->db->prepare("SELECT idStatut, dateStatut FROM lvr_livraisonStatut WHERE idLivraison = ? ORDER BY dateStatut DESC LIMIT 1");
      $currentStmt->execute([$idLivraison]);
      $current = $currentStmt->fetch();
      if ($current) {
        $statusId = (int) $current['idStatut'];
        if ($statusId === 2) {
          throw new \Exception('Livraison déjà effectuée');
        }
        if ($statusId === 3) {
          throw new \Exception('Livraison annulée');
        }
      }

      $calcStmt = $this->db->prepare("SELECT l.prixKg, c.poids_Kg, a.pourcentageZone FROM lvr_livraison l JOIN lvr_colis c ON c.id = l.idColis JOIN lvr_affectation a ON a.id = l.idAffectation WHERE l.id = ?");
      $calcStmt->execute([$idLivraison]);
      $calc = $calcStmt->fetch();
      if (!$calc) {
        throw new \Exception('Livraison introuvable');
      }
      $prixKg = (float) $calc['prixKg'];
      $poids = (float) $calc['poids_Kg'];
      $pourcentage = (float) ($calc['pourcentageZone'] ?? 0);
      if ($poids <= 0) {
        throw new \Exception('Poids du colis invalide');
      }
      $prixBase = $prixKg * $poids;
      $prixTotal = $prixBase * (1 + $pourcentage / 100);

      $this->db->beginTransaction();
      try {
        $payStmt = $this->db->prepare("INSERT INTO lvr_paiement (idLivraison, prix, datePaiement) VALUES (?, ?, ?)");
        $payStmt->execute([$idLivraison, $prixTotal, $datePaiement]);

        $statusStmt = $this->db->prepare("INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut) VALUES (?, 2, ?)");
        $statusStmt->execute([$idLivraison, $datePaiement]);

        $this->db->commit();
      } catch (\Exception $e) {
        $this->db->rollBack();
        throw $e;
      }
    }

    public function annulerLivraison($idLivraison)
    {
      $currentStmt = $this->db->prepare("SELECT idStatut FROM lvr_livraisonStatut WHERE idLivraison = ? ORDER BY dateStatut DESC LIMIT 1");
      $currentStmt->execute([$idLivraison]);
      $current = $currentStmt->fetch();
      if ($current && (int) $current['idStatut'] === 2) {
        throw new \Exception('Impossible d\'annuler une livraison déjà effectuée');
      }

      $stmt = $this->db->prepare("INSERT INTO lvr_livraisonStatut (idLivraison, idStatut, dateStatut) VALUES (?, 3, NOW())");
      $stmt->execute([$idLivraison]);
    }

}
