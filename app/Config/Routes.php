<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/form', 'Form::index');
$routes->post('/form/save', 'Form::save');
// Accept POST directly to '/form' so relative form posts work (no redirect)
$routes->post('/form', 'Form::save');
$routes->get('/form/view/(:num)', 'Form::view/$1');
$routes->get('/form/print/(:num)', 'Form::print/$1');
// Also accept non-numeric segments gracefully and let controller validate
$routes->get('/form/view/(:any)', 'Form::view/$1');

// Support accessing the project by folder name (e.g. http://localhost/project_1/...)
$routes->get('project_1', 'Home::index');
$routes->get('project_1/form', 'Form::index');
$routes->post('project_1/form/save', 'Form::save');
// Also accept POST to 'project_1/form'
$routes->post('project_1/form', 'Form::save');
$routes->get('project_1/form/view/(:num)', 'Form::view/$1');
$routes->get('project_1/form/print/(:num)', 'Form::print/$1');
// Also accept non-numeric segments for project_1 path
$routes->get('project_1/form/view/(:any)', 'Form::view/$1');