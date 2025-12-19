<?php

use app\controllers\StatutController;
use app\controllers\LivraisonController;
use app\controllers\BeneficeController;
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
});