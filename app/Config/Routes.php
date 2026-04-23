<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Setup route (for initialization)
$routes->get('setup', 'Setup::index');

// Default route - redirect to login
$routes->get('/', 'Auth::login');

// Authentication routes
$routes->get('auth/login', 'Auth::login', ['as' => 'login']);
$routes->post('auth/login-submit', 'Auth::loginSubmit', ['as' => 'login-submit']);
$routes->get('auth/signup', 'Auth::signup', ['as' => 'signup']);
$routes->post('auth/signup-submit', 'Auth::signupSubmit', ['as' => 'signup-submit']);
$routes->post('auth/logout', 'Auth::logout', ['as' => 'logout']);

// Admin routes (protected - requires admin role)
$routes->get('admin', 'Admin::index', ['filter' => 'auth:admin']);
$routes->get('admin/users', 'Admin::users', ['filter' => 'auth:admin']);
$routes->post('admin/approve-user/(:num)', 'Admin::approveUser/$1', ['filter' => 'auth:admin']);
$routes->post('admin/deny-user/(:num)', 'Admin::denyUser/$1', ['filter' => 'auth:admin']);
$routes->post('admin/update-role/(:num)', 'Admin::updateRole/$1', ['filter' => 'auth:admin']);
$routes->post('admin/reset-password/(:num)', 'Admin::resetPassword/$1', ['filter' => 'auth:admin']);
$routes->post('admin/delete-user/(:num)', 'Admin::deleteUser/$1', ['filter' => 'auth:admin']);

// Form routes (protected - requires login)
$routes->get('form', 'Form::index', ['filter' => 'auth']);
$routes->get('form/list', 'Form::listAll', ['filter' => 'auth']);
$routes->get('form/recent', 'Form::recent', ['filter' => 'auth']);
$routes->post('form/save', 'Form::save', ['filter' => 'auth']);
$routes->post('form', 'Form::save', ['filter' => 'auth']);
$routes->post('form/delete', 'Form::delete', ['filter' => 'auth']);
$routes->get('form/view/(:num)', 'Form::view/$1', ['filter' => 'auth']);
$routes->get('form/print/(:num)', 'Form::print/$1', ['filter' => 'auth']);
$routes->get('form/view/(:any)', 'Form::view/$1', ['filter' => 'auth']);