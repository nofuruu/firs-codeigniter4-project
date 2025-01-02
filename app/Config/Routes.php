<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'UserController::index');
$routes->get('/userController', 'UserController::index');
$routes->post('/userController/tambah', 'UserController::tambah');
$routes->get('/userController/edit/(:num)', 'UserController::edit/$1');
$routes->get('/userController/delete/(:num)', 'UserController::delete/$1');
$routes->get('userController/export', 'userController::export');
$routes->post('/userController/import', 'UserController::import');
$routes->post('/userController/delete/(:num)', 'UserController::delete/$1');
$routes->get('/userController/getData', 'UserController::getData');


