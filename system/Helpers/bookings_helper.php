<?php

use App\Models\Bookings_Model;

function getAllBookings()
{
    $model = new Bookings_Model();
    return $model->select( 'bookings_tb.*, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'users', 'users.users_id = bookings_tb.users_id' )
        ->findAll();
}

function getAllBookingsByBus()
{
    $model = new Bookings_Model();
    $busId = session()->get( 'conductor' )[ 'bus_id' ];

    return $model->select( 'bookings_tb.*, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'users', 'users.users_id = bookings_tb.users_id' )
        ->where( 'buses_tb.buses_tb_id', $busId ) // ✅ only bookings for this bus
        ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )
        ->findAll();
}

if ( !function_exists( 'generateBookingRef' ) ) {
    function generateBookingRef( $length = 6 )
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $ref        = '';
        for ( $i = 0; $i < $length; $i++ ) {
            $ref .= $characters[ random_int( 0, strlen( $characters ) - 1 ) ];
        }
        return sprintf( '#GTB-%s', $ref );
    }
}

if ( !function_exists( 'generate_booking_id' ) ) {
    /**
     * Generate a booking ID like: #EGT20250904123
     *
     * @param int|null $seq Optional sequence number (default: random 3 digits)
     * @return string
     */
    function generate_booking_id( int $seq = null ) : string
    {
        $today = date( 'Ymd' ); // e.g. 20250904
        $seq   = $seq ?? rand( 100, 999 ); // if no sequence given, random 3 digits
        return sprintf( '#EGT%s%03d', $today, $seq );
    }
}

