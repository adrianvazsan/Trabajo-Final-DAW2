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

$routes->get('login', ['to' => 'AuthController::login']); // Página de login
$routes->post('login/process', ['to' => 'AuthController::loginProcess']); // Procesar login
$routes->get('register', ['to' => 'AuthController::register']); // Página de registro
$routes->post('register/process', ['to' => 'AuthController::registerProcess']); // Procesar registro
$routes->get('logout', ['to' => 'AuthController::logout']); // Cerrar sesión
