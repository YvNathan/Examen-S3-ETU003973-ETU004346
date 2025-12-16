<?php

namespace app\controllers;

use flight\Engine;
use app\models\Trajets;
use Flight;

class TrajetController
{

    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function detail($id)
    {
        $parcoursModel = new Trajets(Flight::db());

        $parcours = $parcoursModel->getParcours($id);
        $trajets  = $parcoursModel->getTrajetsByParcours($id);

        $this->app->render('detail', [
            'parcours' => $parcours,
            'trajets'  => $trajets
        ]);
    }

    public function trajetsLesPlusRentablesParJour()
    {
        $trajetsModel = new Trajets(Flight::db());
        $jour = $_GET['jour'] ?? null;
        if ($jour !== null) {
            $trajetsParJour = $trajetsModel->getTrajetsLesPlusRentablesPourJour($jour);
        } else {
            $trajetsParJour = $trajetsModel->getTrajetsLesPlusRentablesTousLesJours();
        }

        $this->app->render('trajets_rentables', [
            'trajetsParJour' => $trajetsParJour,
            'jour'           => $jour
        ]);
    }
}
