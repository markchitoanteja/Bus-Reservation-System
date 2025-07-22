<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Home routes
$routes->get( '/', 'Home::index' );
$routes->get( '/my_bookings', 'Home::my_bookings' );

// Admin routes
$routes->get( '/admin/dashboard', 'Admin::index' );
$routes->get( '/admin/bookings', 'Admin::viewBookings' );
$routes->get( '/admin/passengers', 'Admin::viewPassengers' );
$routes->get( '/admin/routes', 'Admin::viewRoutes' );
$routes->get( '/admin/buses', 'Admin::viewBuses' );
$routes->get( '/admin/settings', 'Admin::viewSettings' );

// Server side routes
$routes->post( '/login', 'Auth::login' );
$routes->post( '/signup', 'Auth::signup' );
$routes->post( '/update_profile', 'Auth::update_profile' );
$routes->post( '/logout', 'Auth::logout' );
