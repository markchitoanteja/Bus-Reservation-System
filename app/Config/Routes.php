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
$routes->get( '/admin/schedules', 'Admin::viewSchedules' );
$routes->get( '/admin/settings', 'Admin::viewSettings' );

// Server side routes
$routes->post( '/login', 'Auth::login' );
$routes->post( '/signup', 'Auth::signup' );
$routes->post( '/updateProfile', 'Auth::updateProfile' );
$routes->post( '/logout', 'Auth::logout' );

/* Notifications Controller */
$routes->get( 'admin/notifications/CheckUpdatesNotifications', 'Notifications::CheckUpdatesNotifications' );
$routes->get( 'admin/notifications/fetchUpdatesNotifications', 'Notifications::fetchUpdatesNotifications' );
$routes->post( 'admin/notifications/markAsSeen', 'Notifications::markAsSeen' );

/* Pages Controller */

/* Passengers Controller */
$routes->post( '/admin/passengers/fetch', 'Pages\Passengers::fetch' );

// Routes Controller
$routes->post( '/admin/routes/checkRouteExists', 'Pages\Routes::checkRouteExists' );
$routes->post( '/admin/routes/checkEditRouteExists', 'Pages\Routes::checkEditRouteExists' );
$routes->post( '/admin/routes/addRoute', 'Pages\Routes::addRoute' );
$routes->post( '/admin/routes/editRoute', 'Pages\Routes::editRoute' );
$routes->post( '/admin/routes/deleteRoute', 'Pages\Routes::deleteRoute' );

// Buses Controller
$routes->post( '/admin/buses/checkBusExists', 'Pages\Buses::checkBusExists' );
$routes->post( '/admin/buses/checkEditBusExists', 'Pages\Buses::checkEditBusExists' );
$routes->post( '/admin/buses/addBus', 'Pages\Buses::addBus' );
$routes->post( '/admin/buses/editBus', 'Pages\Buses::editBus' );
$routes->post( '/admin/buses/deleteBus', 'Pages\Buses::deleteBus' );

// Bus Travel Schedules Controller
$routes->post( '/admin/schedules/checkBusTravelScheduleExists', 'Pages\Schedules::checkBusTravelScheduleExists' );
$routes->post( '/admin/schedules/checkEditBusTravelScheduleExists', 'Pages\Schedules::checkEditBusTravelScheduleExists' );
$routes->post( '/admin/schedules/addBusTravelSchedule', 'Pages\Schedules::addBusTravelSchedule' );
$routes->post( '/admin/schedules/editBusTravelSchedule', 'Pages\Schedules::editBusTravelSchedule' );
$routes->post( '/admin/schedules/deleteBusTravelSchedule', 'Pages\Schedules::deleteBusTravelSchedule' );

// Routes Schedules Controller
$routes->post( '/admin/schedules/getBusesByDate', 'Pages\Schedules::getBusesByDate' );
$routes->post( '/admin/schedules/checkRouteScheduleExists', 'Pages\Schedules::checkRouteScheduleExists' );
$routes->post( '/admin/schedules/checkEditRouteScheduleExists', 'Pages\Schedules::checkEditRouteScheduleExists' );
$routes->post( '/admin/schedules/addRouteSchedule', 'Pages\Schedules::addRouteSchedule' );
$routes->post( '/admin/schedules/editRouteSchedule', 'Pages\Schedules::editRouteSchedule' );
$routes->post( '/admin/schedules/deleteRouteSchedule', 'Pages\Schedules::deleteRouteSchedule' );


/* Booking Controller */
$routes->post( '/booking/getAvailableBuses', 'Booking::getAvailableBuses' );
$routes->post( '/booking/getBusAvailableSeats', 'Booking::getBusAvailableSeats' );
$routes->post( '/booking/getFare', 'Booking::getFare' );
$routes->post( '/booking/submitBooking', 'Booking::submitBooking' );



