<?php

namespace app\controllers;

use flight\Engine;
use app\models\Parcours;
use Flight;

class ParcoursController {

	protected Engine $app;

	public function __construct($app) {
		$this->app = $app;
	}

	public function getParcours() {
        $parcoursModel = new Parcours(Flight::db());
        $parcours = $parcoursModel->getParcours();
		$this->app->render('index', ['parcours' => $parcours]);
	}

	public function getParcoursById($id) {
        $parcoursModel = new Parcours(Flight::db());
        $parcours = $parcoursModel->getParcoursById($id);
		$this->app->render('detail', ['parcours' => $parcours]);
	}
}