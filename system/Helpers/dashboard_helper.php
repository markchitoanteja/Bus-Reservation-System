<?php


use App\Models\Bookings_Model;
use App\Models\Passengers_Model;

function getTotalBookingsToday()
{
    $today = date( 'Y-m-d' );

    $model = new Bookings_Model();
    return $model->select( 'bookings_tb.*, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'users', 'users.users_id = bookings_tb.users_id' )
        ->where( 'DATE(bookings_tb.created_at)', $today ) // ✅ extract only the date part
        ->countAllResults();
}

function getMostBookedRoutes() : array
{
    $model = new Bookings_Model();

    // Get counts grouped by route
    $routes = $model->select( 'routes_tb.origin, routes_tb.destination, COUNT(*) as total_bookings' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->groupBy( 'routes_tb.routes_tb_id' )
        ->orderBy( 'total_bookings', 'DESC' )
        ->findAll();

    if ( empty( $routes ) ) {
        return [];
    }

    // Get highest total
    $max = $routes[ 0 ][ 'total_bookings' ];

    // Get overall total bookings
    $overall = array_sum( array_column( $routes, 'total_bookings' ) );

    // Filter only those equal to max and calculate %
    return array_map( function ($r) use ($overall) {
        $r[ 'percentage' ] = $overall > 0 ? round( ( $r[ 'total_bookings' ] / $overall ) * 100, 1 ) : 0;
        return $r;
    }, array_filter( $routes, fn( $r ) => $r[ 'total_bookings' ] == $max ) );
}

function getBusesInTransit() : int
{
    $model = new Passengers_Model();

    return $model->select( 'buses_tb.buses_tb_id' )
        ->join( 'bookings_tb', 'bookings_tb.bookings_tb_id = passengers_tb.bookings_tb_id' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->where( 'passengers_tb.travel_status', 'In Transit' )
        ->groupBy( 'buses_tb.buses_tb_id' )
        ->countAllResults();
}

function getAllRecentBookings()
{
    $model = new Bookings_Model();
    return $model->select( 'bookings_tb.*, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'users', 'users.users_id = bookings_tb.users_id' )
        ->limit( 10 )
        ->findAll();
}