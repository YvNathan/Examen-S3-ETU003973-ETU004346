<?php

namespace app\controllers;

use app\models\Panne;
use flight\Engine;
use Flight;

class PanneController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function pannes() {
        $panneModel = new Panne(Flight::db());
        $idVehicule = isset($_GET['idVehicule']) ? $_GET['idVehicule'] : null;

        $pannes = $panneModel->getPannes($idVehicule);
        $vehiculesUniques = $panneModel->getVehiculesUniques();

        $this->app->render('pannes', [
            'pannes' => $pannes,
            'vehiculesUniques' => $vehiculesUniques,
            'idVehicule' => $idVehicule
        ]);
    }
}
