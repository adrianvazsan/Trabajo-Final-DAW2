<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('home/getUsers', 'Home::getUsers');
$routes->get('home/create', 'Home::create');
$routes->post('home/create', 'Home::create');







