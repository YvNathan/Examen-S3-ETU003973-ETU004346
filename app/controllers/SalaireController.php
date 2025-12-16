<?php

namespace app\controllers;

use app\models\Salaire;
use flight\Engine;
use Flight;

class SalaireController {
    protected Engine $app;

    public function __construct($app) {
        $this->app = $app;
    }

    public function salaireJournalier() {
        $salaireModel = new Salaire(Flight::db());
        $jour = isset($_GET['jour']) ? $_GET['jour'] : null;
        $chauffeurId = isset($_GET['chauffeur_id']) ? $_GET['chauffeur_id'] : null;

        $salaires = $salaireModel->getSalaireJournalierAvecFiltre($jour, $chauffeurId);
        $chauffeurs = $salaireModel->getChauffeurs();

        $this->app->render('salaire_journalier', [
            'salaires' => $salaires,
            'chauffeurs' => $chauffeurs,
            'jour' => $jour,
            'chauffeurId' => $chauffeurId,
        ]);
    }
}
