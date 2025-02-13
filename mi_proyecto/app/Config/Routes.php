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

$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');
$routes->get('users', 'UserController::index'); // Listar usuarios
$routes->get('users/save', 'UserController::saveUser'); // Mostrar formulario para crear usuario
$routes->get('users/save/(:num)', 'UserController::saveUser/$1'); // Mostrar formulario para editar usuario
$routes->post('users/save', 'UserController::saveUser'); // Crear usuario (POST)
$routes->post('users/save/(:num)', 'UserController::saveUser/$1'); // Editar usuario (POST)
$routes->get('users/delete/(:num)', 'UserController::delete/$1'); // Eliminar usuario

// rutas login y registro
$routes->get("login", "AuthController::login"); // Página de login
$routes->post("login/process", "AuthController::processLogin"); //Procesar login
$routes->get("register", "AuthController::register"); //Página de registro
$routes->post("register/process", "AuthController::processRegister"); //Procesar registro
$routes->get("logout", "AuthController::logout"); // Cerrar sesión
$routes->get("dashboard", "AuthController::dashboard"); // Página de dashboard
$routes->get("/", "Home::index"); // Página de graficos







//$routes->get('login', ['to' => 'AuthController::login']); // Página de login
//$routes->post('login/process', ['to' => 'AuthController::loginProcess']); // Procesar login
//$routes->get('register', ['to' => 'AuthController::register']); // Página de registro
//$routes->post('register/process', ['to' => 'AuthController::registerProcess']); // Procesar registro
//$routes->get('logout', ['to' => 'AuthController::logout']); // Cerrar sesión
