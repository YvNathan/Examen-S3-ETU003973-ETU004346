<?php

use app\controllers\ApiExampleController;
use app\controllers\ParcoursController;
use app\controllers\TrajetController;
use app\controllers\VehiculeController;
use app\controllers\PanneController;
use app\controllers\SalaireController;

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// Main routes group
$router->group('', function (Router $router) use ($app) {

	$router->get('/', function () use ($app) {
		$parcoursController = new ParcoursController($app);
		$parcoursController->getParcours();
	});
	
	$router->get('/trajets/rentables', function() use ($app) {
		$controller = new TrajetController($app);
		$controller->trajetsLesPlusRentablesParJour();
	});

	$router->get('/vehicules/par-jour', function() use ($app) {
		$controller = new VehiculeController($app);
		$controller->vehiculesParJour();
	});

	$router->get('/pannes', function() use ($app) {
		$controller = new PanneController($app);
		$controller->pannes();
	});

	$router->get('/salaires/journalier', function() use ($app) {
		$controller = new SalaireController($app);
		$controller->salaireJournalier();
	});

	$router->get('/detail/@id:[0-9]+', function($id) use ($app) {
		$parcoursController = new ParcoursController($app);
		$parcoursController->getParcoursById($id);
	});

	$router->get('/parcours/@id:[0-9]+', function ($id) use ($app) {
		$controller = new TrajetController($app);
		$controller->detail($id);
	});


});