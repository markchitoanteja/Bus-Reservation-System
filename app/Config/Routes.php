<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home routes
 $routes->get('/', 'Home::index');

// Admin routes
$routes->get('/admin', 'Admin::index');

// Server side routes
$routes->post('/login', 'Auth::login');
$routes->post('/signup', 'Auth::signup');
$routes->post('/logout', 'Auth::logout');
