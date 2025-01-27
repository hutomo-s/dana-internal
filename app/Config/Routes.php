<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->get('/dashboard/login', 'Login::index');
    
$routes->get('/dashboard/logout', 'Logout::index');

