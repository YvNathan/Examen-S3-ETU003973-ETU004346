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
        $this->app->render('statut', ['listeStatut' => $liste]);
    }

	public function acheverLivraison($id) {
        $statutModel = new Statut(Flight ::db());
        $date = Flight::request()->data->datePaiement;  
        $statutModel->acheverLivraison($id,$date);
	}
}