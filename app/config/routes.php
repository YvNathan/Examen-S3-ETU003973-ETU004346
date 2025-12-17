<?php

use app\controllers\ApiExampleController;
use app\controllers\StatutController;

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;

/** 
 * @var Router $router 
 * @var Engine $app
 */

$router->group('', function (Router $router) use ($app) {

	$router->get('/statut', function () use ($app) {
		$statutcontroller = new StatutController($app);
		$statutcontroller->getStatutLivraison();
	});
	
});