<?php

use App\Models\BusRoutes_Model;
use App\Models\BusTravelSchedules_Model;

function getAllBusSchedules()
{
    $busRoutesModel = new BusTravelSchedules_Model();

    return $busRoutesModel
        ->select( '
        bus_trav_sched_tb.*,
        buses_tb.buses_tb_id,
        buses_tb.bus_name,
        buses_tb.bus_no,
        buses_tb.bus_type,
    ' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )
        ->findAll();

}
function getAllRoutesSchedules()
{
    $busRoutesModel = new BusRoutes_Model();

    return $busRoutesModel
        ->select( '
        bus_routes_tb.*,
        bus_trav_sched_tb.date,
        bus_trav_sched_tb.occupied_seats,
        buses_tb.bus_name,
        buses_tb.bus_no,
        buses_tb.bus_type,
        routes_tb.origin,
        routes_tb.destination
    ' )
        ->join( 'bus_trav_sched_tb', 'bus_trav_sched_tb.bus_trav_sched_tb_id = bus_routes_tb.bus_trav_sched_tb_id' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_routes_tb.routes_tb_id' )
        ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )
        ->orderBy( 'bus_routes_tb.dep_time', 'ASC' )
        ->orderBy( 'buses_tb.bus_no', 'ASC' )
        ->findAll();

}




