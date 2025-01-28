<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard/login', 'Login::index');
    
$routes->get('/dashboard/logout', 'Logout::index');


$routes->group('api', static function($routes) {

    $routes->post('login/submit', 'Login::submit');

    $routes->get('users/get_line_manager/(:num)/(:num)', 'Users::get_line_managers/$1/$2');
    
    $routes->post('users/store', 'Users::store');

});

$routes->group('dashboard', ['filter' => [\App\Filters\DashboardAuthentication::class]], static function($routes) {
    
    $routes->get('users', 'Users::index');
    
    $routes->get('users/create', 'Users::create');

    $routes->get('exception-papers', 'ExceptionPapers::index');
    
    $routes->get('/', 'Dashboard::index');

});