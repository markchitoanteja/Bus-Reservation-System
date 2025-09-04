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

function getAllBusShedules()
{
    $model = new Buses_Model();
    return $model->findAll();
}

