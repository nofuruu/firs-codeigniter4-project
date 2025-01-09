<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Login & Register Routes
$routes->get('/', 'loginController::index', ['filter' => 'noauth']);
$routes->get('/login', 'loginController::index', ['filter' => 'noauth']);
$routes->post('/login', 'loginController::login', ['filter' => 'noauth']);


// ROUTES REGISTER
$routes->post('/register', 'loginController::register');
$routes->get('/register', 'loginController::register');


// userController form routes
$routes->get('/userController', 'UserController::index', ['filter' => 'auth']);
$routes->post('/userController/tambah', 'UserController::tambah');
$routes->get('/userController/edit/(:num)', 'UserController::edit/$1');
$routes->get('/userController/delete/(:num)', 'UserController::delete/$1');
$routes->get('/userController/export', 'UserController::export');
$routes->post('/userController/import', 'UserController::import');
$routes->post('/userController/delete/(:num)', 'UserController::delete/$1');
$routes->post('/userController/getData', 'UserController::getData');
$routes->get('/userController/getData', 'UserController::getData');
$routes->post('/logout', 'loginController::logout');
$routes->get('/logout', 'loginController::logout');


// masterController form routes
$routes->get('/masterController', 'MasterController::index', ['filter' => 'auth']);
$routes->get('/masterController/addUser', 'MasterController::addUser');
$routes->post('/masterController/addUser', 'MasterController::addUser');
$routes->get('/masterController/getData', 'MasterController::getData');
$routes->post('/masterController/getData', 'MasterController::getData');
$routes->post('/masterController/deleteUser', 'MasterController::deleteUser');
$routes->get('/masterController/getUser', 'MasterController::getUser');
$routes->post('/masterController/getUser', 'MasterController::getUser');

$routes->get('/masterController/updateUser', 'MasterController::updateUser');
$routes->post('/masterController/updateUser', 'MasterController::updateUser');