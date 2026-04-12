<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/form', 'Form::index');
$routes->post('/form/save', 'Form::save');
$routes->get('/form/view/(:num)', 'Form::view/$1');
$routes->get('/form/print/(:num)', 'Form::print/$1');