<?php

namespace app\controllers;

use flight\Engine;
use app\models\Statut;
use Flight;

class StatutController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

    public function getStatutLivraison(){
        $statutModel = new Statut(Flight::db());
        $liste=$statutModel->getLivraisonStatut();
        $this->app->render('statut', [
            'listeStatut' => $liste,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

	public function acheverLivraison($idLivraison, $datePaiement) {
        $statutModel = new Statut(Flight::db());
        $statutModel->acheverLivraison($idLivraison, $datePaiement);
	}

	public function annulerLivraison($idLivraison) {
        $statutModel = new Statut(Flight::db());
        $statutModel->annulerLivraison($idLivraison);
	}
}