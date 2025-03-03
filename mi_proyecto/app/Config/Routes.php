<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Rutas para la página de inicio
$routes->get('login', 'AuthController::login'); // Página de login
$routes->post('login/process', 'AuthController::loginProcess'); // Procesar login
$routes->get('register', 'AuthController::register'); // Página de registro
$routes->post('register/process', 'AuthController::registerProcess'); // Procesar registro
$routes->get('logout', 'AuthController::logout'); // Cerrar sesión
// Rutas para users_table
$routes->get('users', 'UserController::index'); // Listar usuarios
$routes->get('users/save', 'UserController::saveUser'); // Mostrar formulario para crear usuario
$routes->get('users/save/(:num)', 'UserController::saveUser/$1'); // Mostrar formulario para editar usuario
$routes->post('users/save', 'UserController::saveUser'); // Crear usuario (POST)
$routes->post('users/save/(:num)', 'UserController::saveUser/$1'); // Editar usuario (POST)
$routes->get('users/delete/(:num)', 'UserController::delete/$1'); // Eliminar usuario
$routes->get('users/export', 'UserController::exportCSV');// Exportar usuarios a CSV


// Rutas para products_table
$routes->get('products', 'ProductController::index'); // Listar productos
$routes->get('products/save', 'ProductController::saveProduct'); // Mostrar formulario para crear producto
$routes->get('products/save/(:num)', 'ProductController::saveProduct/$1'); // Mostrar formulario para editar producto
$routes->post('products/save', 'ProductController::saveProduct'); // Crear producto (POST)
$routes->post('products/save/(:num)', 'ProductController::saveProduct/$1'); // Editar producto (POST)
$routes->get('products/delete/(:num)', 'ProductController::delete/$1'); // Eliminar producto
$routes->get('products/restore/(:num)', 'ProductController::restore/$1'); // Restaurar producto
$routes->get('products/export', 'ProductController::exportCSV');// Exportar productos a CSV


// Rutas para feedback_table
$routes->get('feedback', 'FeedbackController::index'); // Listar feedbacks
$routes->get('feedback/save', 'FeedbackController::saveFeedback'); // Mostrar formulario para crear feedback
$routes->get('feedback/save/(:num)', 'FeedbackController::saveFeedback/$1'); // Mostrar formulario para editar feedback
$routes->post('feedback/save', 'FeedbackController::saveFeedback'); // Crear feedback (POST)
$routes->post('feedback/save/(:num)', 'FeedbackController::saveFeedback/$1'); // Editar feedback (POST)
$routes->get('feedback/delete/(:num)', 'FeedbackController::delete/$1'); // Eliminar feedback
$routes->get('feedback/export', 'FeedbackController::exportCSV');// Exportar feedbacks a CSV


// Rutas para profile_table
$routes->get('profiles', 'ProfileController::index');
//$routes->get('profiles/edit/(:num)', 'ProfileController::edit/$1');
$routes->post('profiles/update/(:num)', 'ProfileController::update/$1');
$routes->post('profiles/saveUser', 'ProfileController::saveUser');





// Rutas para la página del calendario
$routes->get('/fetch-events', 'EventController::fetchEvents');
$routes->post('/add-event', 'EventController::addEvent');
$routes->delete('/delete-event/(:num)', 'EventController::deleteEvent/$1');

// Rutas para el calendario
$routes->get('/calendar', 'EventController::index');

// Rutas para cerrar sesión
$routes->get('/logout', 'ProfileController::logout');

// Rutas para la página de la grafica
$routes->get('grafica/datos', 'GrafiController::getChartData'); // API para la gráfica
$routes->get('grafica', 'GrafiController::chart'); // Vista de la gráfica




