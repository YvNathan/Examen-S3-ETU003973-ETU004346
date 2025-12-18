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
      $sql = "CALL p_gestion_statut(?, ?)";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$idLivraison, $datePaiement]);
    }

    public function annulerLivraison($idLivraison)
    {
      $sql = "UPDATE lvr_livraisonStatut SET idStatut = 3, dateStatut = CURDATE() WHERE idLivraison = ? AND idStatut = 1";
      $stmt = $this->db->prepare($sql);
      $stmt->execute([$idLivraison]);
    }

}
