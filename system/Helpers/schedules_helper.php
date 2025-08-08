<?php

use App\Models\Schedules_Model;
function getAllSchedules()
{
    $schedulesModel = new Schedules_Model();

    return $schedulesModel->select( 'bus_trav_sched_tb.*, 
    buses_tb.bus_name, 
    buses_tb.bus_no, 
    buses_tb.bus_type, 
    routes_tb.origin, 
    routes_tb.destination' )
        ->join( 'buses_tb', 'buses_tb.buses_tb_id = bus_trav_sched_tb.buses_tb_id' )
        ->join( 'routes_tb', 'routes_tb.routes_tb_id = bus_trav_sched_tb.routes_tb_id' )
        ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )
        ->orderBy( 'bus_trav_sched_tb.dep_time', 'ASC' )
        ->findAll();
}




