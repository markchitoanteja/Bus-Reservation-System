<?php

use App\Models\Buses_Model;
use App\Models\BusTravelSchedules_Model;

function getAllDateShedules()
{
    $model = new BusTravelSchedules_Model();

    $schedules = $model->select( 'bus_trav_sched_tb.*' )
        ->groupBy( 'date' ) // pick one row per date
        ->findAll();

    return $schedules;
}

function getAllDateShedulesByBus()
{
    $model = new BusTravelSchedules_Model();

    // Get bus_id from conductor session
    $busId = session()->get( 'conductor' )[ 'bus_id' ];

    $schedules = $model->select( 'bus_trav_sched_tb.*' )
        ->where( 'bus_trav_sched_tb.buses_tb_id', $busId ) // ✅ only this bus
        ->groupBy( 'bus_trav_sched_tb.date' )              // ✅ unique dates
        ->orderBy( 'bus_trav_sched_tb.date', 'ASC' )       // optional: sort ascending
        ->findAll();

    return $schedules;
}

function getAllBusShedules()
{
    $model = new Buses_Model();
    return $model->findAll();
}

