<?php

namespace app\controllers;

use flight\Engine;
use Flight;

class ReinitController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function confirm()
    {
        $this->app->render('reinit-confirm', [
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function execute()
    {
        try {
            $db = Flight::db();
            
            // Démarrer la transaction
            $db->beginTransaction();
            
            $db->exec("UPDATE lvr_paiement SET idLivraison = NULL");
            $db->exec("DELETE FROM lvr_livraisonStatut");
            $db->exec("DELETE FROM lvr_livraison");
            $db->exec("DELETE FROM lvr_affectation");
            
            $db->exec("ALTER TABLE lvr_livraisonStatut AUTO_INCREMENT = 1");
            $db->exec("ALTER TABLE lvr_livraison AUTO_INCREMENT = 1");
            $db->exec("ALTER TABLE lvr_affectation AUTO_INCREMENT = 1");
            
            $db->commit();
            
            Flight::redirect(Flight::get('flight.base_url') . '/');
        } catch (\Exception $e) {
            try {
                Flight::db()->rollBack();
            } catch (\Exception $rollbackError) {
            }
            Flight::redirect(Flight::get('flight.base_url') . '/accueil');
        }
    }
}
