<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home routes
 $routes->get('/', 'Home::index');
 $routes->get('/my_bookings', 'Home::my_bookings');

// Admin routes
$routes->get('/admin/dashboard', 'Admin::index');

// Server side routes
$routes->post('/login', 'Auth::login');
$routes->post('/signup', 'Auth::signup');
$routes->post('/update_profile', 'Auth::update_profile');
$routes->post('/logout', 'Auth::logout');
