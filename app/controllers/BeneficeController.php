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

    /**
     * Page principale des bénéfices avec filtres
     */
    public function index()
    {
        $beneficeModel = new Benefice(Flight::db());
        
        // Récupération des paramètres de filtre
        $periode = $_GET['periode'] ?? 'jour';
        $jour = $_GET['jour'] ?? null;
        $annee = $_GET['annee'] ?? null;
        $mois = $_GET['mois'] ?? null;

        // Récupération des données selon la période
        $benefices = [];
        switch ($periode) {
            case 'jour':
                $benefices = $beneficeModel->getBeneficesParJour($jour);
                break;
            case 'mois':
                $benefices = $beneficeModel->getBeneficesParMois($annee, $mois);
                break;
            case 'annee':
                $benefices = $beneficeModel->getBeneficesParAnnee($annee);
                break;
        }

        $this->app->render('benefices', [
            'benefices' => $benefices,
            'periode' => $periode,
            'jour' => $jour,
            'annee' => $annee,
            'mois' => $mois,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }

    /**
     * Page des détails des livraisons
     */
    public function details()
    {
        $beneficeModel = new Benefice(Flight::db());
        $benefices = $beneficeModel->getBeneficesDetailles();

        $this->app->render('benefices-details', [
            'benefices' => $benefices,
            'baseUrl' => Flight::get('flight.base_url'),
        ]);
    }
}