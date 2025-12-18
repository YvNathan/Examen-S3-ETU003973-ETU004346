<?php

namespace app\controllers;

use flight\Engine;
use app\models\Benefice;
use Flight;

class BeneficeController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $model = new Benefice(Flight::db());

        $annee = $_GET['annee'] ?? null;
        $mois  = $_GET['mois'] ?? null;
        $jour  = $_GET['jour'] ?? null;

        if ($jour) {
            $affichage = 'date';
        } elseif ($annee && $mois) {
            $affichage = 'mois';
        } elseif ($annee) {
            $affichage = 'annee';
        } else {
            $affichage = 'date';
        }

        $benefices = $model->getBeneficesParPeriode($annee, $mois, $jour);

        $this->app->render('benefices', [
            'benefices' => $benefices,
            'annee' => $annee,
            'mois' => $mois,
            'jour' => $jour,
            'affichage' => $affichage,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }


    public function details()
    {
        $model = new Benefice(Flight::db());
        $benefices = $model->getBeneficesDetailles();

        $this->app->render('benefices-details', [
            'benefices' => $benefices,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}
