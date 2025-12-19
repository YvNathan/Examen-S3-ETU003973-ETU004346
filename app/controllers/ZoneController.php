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
        $this->app->render('zone-list', ['zones' => $zones, 'message' => '']);
    }

    public function add()
    {
        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $pourcentage = floatval($_POST['pourcentage'] ?? 0);

            if ($nom !== '') {
                $model = new Zone($this->app->db());
                $model->add($nom, $pourcentage);
                $this->app->redirect('/zones');
            } else {
                $message = 'Le nom est obligatoire.';
            }
        }

        $this->app->render('zone-form', [
            'action' => 'add',
            'zone' => ['nom' => $nom ?? '', 'pourcentage' => $pourcentage ?? 0],
            'message' => $message
        ]);
    }

    public function edit($id)
    {
        $model = new Zone($this->app->db());
        $zone = $model->getZoneById($id);

        if (!$zone) {
            $this->app->redirect('/zones');
        }

        $message = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = trim($_POST['nom'] ?? '');
            $pourcentage = floatval($_POST['pourcentage'] ?? 0);

            if ($nom !== '') {
                $model->update($id, $nom, $pourcentage);
                $this->app->redirect('/zones');
            } else {
                $message = 'Le nom est obligatoire.';
            }
        }

        $this->app->render('zone-form', [
            'action' => 'edit',
            'zone' => $zone,
            'message' => $message
        ]);
    }

    public function delete($id)
    {
        $model = new Zone($this->app->db());

        $this->app->db()->prepare("UPDATE lvr_affectation SET idZone = 6 WHERE idZone = ?")
                       ->execute([$id]);

        $model->delete($id);

        $zones = $model->getZones();

        $this->app->render('zone-list', [
            'zones' => $zones,
            'message' => 'Zone supprimée avec succès.'
        ]);
    }
}