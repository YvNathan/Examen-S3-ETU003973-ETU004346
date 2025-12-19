<?php

namespace app\controllers;

use flight\Engine;
use app\models\BeneficeVehicule;
use Flight;

class BeneficeVehiculeController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $model = new BeneficeVehicule(Flight::db());
        $vehicules = $model->getVehicules();

        $this->app->render('benefices-vehicules', [
            'vehicules' => $vehicules,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    public function details($idVehicule)
    {
        $model = new BeneficeVehicule(Flight::db());
        $details = $model->getDetails($idVehicule);

        $totaux = [
            'ca' => 0,
            'coutVehicule' => 0,
            'coutLivreur' => 0,
            'benefice' => 0,
            'nb' => 0,
        ];
        foreach ($details as $row) {
            $ca = $row['chiffreAffaires'] ?? 0;
            $cv = $row['coutVehicule'] ?? 0;
            $cl = $row['coutLivreur'] ?? 0;
            $totaux['ca'] += $ca;
            $totaux['coutVehicule'] += $cv;
            $totaux['coutLivreur'] += $cl;
            $totaux['benefice'] += $ca - ($cv + $cl);
            $totaux['nb']++;
        }

        $this->app->render('benefices-vehicules-details', [
            'details' => $details,
            'totaux' => $totaux,
            'idVehicule' => $idVehicule,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}
