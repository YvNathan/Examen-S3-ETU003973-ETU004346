<?php

namespace app\controllers;

use app\models\Vehicules;
use flight\Engine;
use Flight;

class VehiculeController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function vehiculesParJour() {
        $vehiculeModel = new Vehicules(Flight::db());
        $jour = isset($_GET['jour']) ? $_GET['jour'] : null;

        $vehiculesParJour = $vehiculeModel->getVehiculesParJour($jour);

        $this->app->render('vehicules_par_jour', [
            'vehiculesParJour' => $vehiculesParJour,
            'jour' => $jour
        ]);
    }
}
