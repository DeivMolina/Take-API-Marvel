<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->post('/fetch', 'Home::fetchFromApi');
$routes->get('home/view/(:num)', 'Home::view/$1');
$routes->post('home/create', 'Home::create');
$routes->post('home/update', 'Home::update');
$routes->delete('home/delete/(:num)', 'Home::delete/$1');
$routes->post('home/search', 'Home::search');


