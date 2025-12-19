
<?php

use app\controllers\StatutController;
use app\controllers\LivraisonController;
use app\controllers\BeneficeController;
use app\controllers\BeneficeVehiculeController;
use app\controllers\ZoneController;
use app\controllers\ReinitController;

use flight\Engine;
use flight\net\Router;


/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function (Router $router) use ($app) {

	$router->get('/', function () use ($app) {
		$app->render('landing');
	});

	$router->get('/accueil', function () use ($app) {
		$app->render('index');
	});

	$router->get('/statut', function () use ($app) {
		$statutcontroller = new StatutController($app);
		$statutcontroller->getStatutLivraison();
	});

	$router->get('/zones', function () use ($app) {
	$controller = new ZoneController($app);
	$controller->index();
});

$router->get('/zones/add', function () use ($app) {
	$controller = new ZoneController($app);
	$controller->add();
});
$router->post('/zones/add', function () use ($app) {
	$controller = new ZoneController($app);
	$controller->add();
});

$router->get('/zones/edit/(\d+)', function ($id) use ($app) {
	$controller = new ZoneController($app);
	$controller->edit($id);
});
$router->post('/zones/edit/(\d+)', function ($id) use ($app) {
	$controller = new ZoneController($app);
	$controller->edit($id);
});

$router->get('/zones/delete/(\d+)', function ($id) use ($app) {
	$controller = new ZoneController($app);
	$controller->delete($id);
});
	$router->post('/statut/achever', function () use ($app) {
		$statutcontroller = new StatutController($app);
		$idLivraison = $_POST['idLivraison'] ?? null;
		$datePaiement = $_POST['datePaiement'] ?? null;
		$statutcontroller->acheverLivraison($idLivraison, $datePaiement);
		$app->redirect('/statut');
	});

	$router->post('/statut/annuler', function () use ($app) {
		$statutcontroller = new StatutController($app);
		$idLivraison = $_POST['idLivraison'] ?? null;
		$statutcontroller->annulerLivraison($idLivraison);
		$app->redirect('/statut');
	});

	  $router->get('/livraisons/nouveau', function () use ($app) {
        $controller = new LivraisonController($app);
        $controller->nouveau();		
    });

    $router->post('/livraisons/nouveau', function () use ($app) {
        $controller = new LivraisonController($app);
        $controller->enregistrer();
    });

	$router->get('/benefices', function () use ($app) {
		$controller = new BeneficeController($app);
		$controller->index();
	});

	$router->get('/benefices/details', function () use ($app) {
		$controller = new BeneficeController($app);
		$controller->details();
	});	

	$router->get('/benefices/vehicules', function () use ($app) {
		$controller = new BeneficeVehiculeController($app);
		$controller->index();
	});

	$router->get('/benefices/vehicules/@id', function ($id) use ($app) {
		$controller = new BeneficeVehiculeController($app);
		$controller->details($id);
	});

	$router->get('/reinit', function () use ($app) {
		$controller = new ReinitController($app);
		$controller->confirm();
	});

	$router->post('/reinit/execute', function () use ($app) {
		$controller = new ReinitController($app);
		$controller->execute();
	});
});