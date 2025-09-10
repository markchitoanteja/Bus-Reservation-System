<?php

use App\Models\Bookings_Model;

function getMyBookings()
{
    $model = new Bookings_Model();
    return $model->select( 'bookings_tb.*, bookings_tb.created_at AS date_created, bus_routes_tb.*,bus_trav_sched_tb.*,routes_tb.*,buses_tb.*,users.*' )
        ->join( 'bus_routes_tb', 'bus_routes_tb.bus_routes_tb_id = bookings_tb.bus_routes_tb_id' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'users', 'users.users_id = bookings_tb.users_id' )
        ->where( 'bookings_tb.users_id', session()->get( 'user' )[ 'users_id' ] )
        ->findAll();
}