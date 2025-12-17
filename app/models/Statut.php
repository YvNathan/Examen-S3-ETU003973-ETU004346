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
      $stmt = $this->db->query("SELECT * FROM v_getStatusLivraison");
        return $stmt->fetchAll();
    }

    public function acheverLivraison($idLivraison, $datePaiement)
    {
      $sql = "CALL p_gestio_statut($idLivraison, '$datePaiement')";
      $this->db->query($sql);
    } 

}
