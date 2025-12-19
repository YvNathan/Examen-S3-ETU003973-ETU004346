<?php

namespace app\controllers;

use flight\Engine;
use app\models\Vehicules;
use app\models\Livreurs;
use app\models\Colis;
use app\models\Livraison;
use app\models\Zone;
use Flight;

class LivraisonController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function nouveau()
    {
        $modelV = new Vehicules($this->app->db());
        $modelL = new Livreurs($this->app->db());
        $modelC = new Colis($this->app->db());
        $modelZ = new Zone($this->app->db());

        $data = [
            'vehicules' => $modelV->getVehicules(),
            'livreurs'  => $modelL->getLivreurs(),
            'colis'     => $modelC->getColisDisponibles(),
            'baseUrl'   => Flight::get('flight.base_url'),
        ];

        $this->app->render('form', $data);
    }

    public function enregistrer()
    {
        $req = $this->app->request()->data;
        $modelLivraison = new Livraison($this->app->db());

        try {
            $modelLivraison->creer(
                $req->idVehicule,
                $req->idLivreur,
                $req->coutVehicule,
                $req->idColis,
                $req->prixKg,
                $req->dateLivraison
            );

            $baseUrl = Flight::get('flight.base_url');
            $this->app->redirect($baseUrl . '/livraisons/nouveau?success=1');

        } catch (\Exception $e) {
            Flight::render('form', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}