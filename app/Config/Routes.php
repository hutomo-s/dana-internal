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

    $routes->post('exception-papers/store', 'ExceptionPapers::store');
    
    $routes->post('exception-papers/approve', 'ExceptionPapers::approve');

});

$routes->group('dashboard', ['filter' => [\App\Filters\DashboardAuthentication::class]], static function($routes) {
    
    $routes->get('users', 'Users::index');
    
    $routes->get('users/create', 'Users::create');

    $routes->get('exception-papers/(:num)', 'ExceptionPapers::show/$1');
    
    $routes->get('exception-papers/waiting-my-approval', 'ExceptionPapers::waiting_my_approval');

    $routes->get('exception-papers', 'ExceptionPapers::index');
    
    $routes->get('exception-papers/create', 'ExceptionPapers::create');
    
    $routes->get('/', 'Dashboard::index');

});