<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
// $routes->set404Override();
//Override 404 and give response in JSON format
$routes->set404Override(function ($a) {
	header('Content-Type: application/json');
	echo json_encode([
				"status"  => false,
				"code"    => 404,
				"message" => "Route not found",
			], JSON_PRETTY_PRINT);
	die();
});

// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');

$routes->group('api', static function ($routes) {
    $routes->post('sign_in', 'LoginController::create', ['namespace' => 'App\Controllers\Api\User\Auth']);
    $routes->post('sign_up', 'RegisterController::register', ['namespace' => 'App\Controllers\Api\User\Auth']);

    $routes->group('', ['filter' => 'authFilter'], function ($routes) {
			$routes->get('todo', 'TodoController::index', ['namespace' => 'App\Controllers\Api']);
			$routes->resource('todo', ['namespace' => 'App\Controllers\Api', 'except' => 'new,edit']);
        
    });
});


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
