<?php

use App\Models\Buses_Model;

function getAllBuses()
{
    $busModel = new Buses_Model();
    return $busModel->findAll(); // You can add orderBy if needed
}
