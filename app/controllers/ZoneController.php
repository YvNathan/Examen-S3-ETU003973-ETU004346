<?php
namespace app\controllers;

use flight\Engine;
use app\models\Zone;

class ZoneController
{
    protected Engine $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index()
    {
        $model = new Zone($this->app->db());
        $zones = $model->getZones();

        $this->app->render('zone/zone-list', ['zones' => $zones]);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $pourcentage = floatval($_POST['pourcentage'] ?? 0);

            if ($nom !== '') {
                $model = new Zone($this->app->db());
                $model->add($nom, $pourcentage);
                $this->app->redirect('/zones');
            }
        }

        $this->app->render('zone/zone-form', [
            'action' => 'add',
            'zone' => ['nom' => '', 'pourcentage' => 0]
        ]);
    }

    public function edit($id)
    {
        $model = new Zone($this->app->db());
        $zone = $model->getZoneById($id);

        if (!$zone) {
            $this->app->redirect('/zones');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $pourcentage = floatval($_POST['pourcentage'] ?? 0);

            if ($nom !== '') {
                $model->update($id, $nom, $pourcentage);
                $this->app->redirect('/zones');
            }
        }

        $this->app->render('zone/zone-form', [
            'action' => 'edit',
            'zone' => $zone
        ]);
    }

    public function delete($id)
    {
        $model = new Zone($this->app->db());
        $model->delete($id);
        $this->app->redirect('/zones');
    }
}