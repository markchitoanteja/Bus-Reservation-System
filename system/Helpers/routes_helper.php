<?php

use App\Models\Routes_Model;

function getAllRoutes()
{
    $routesModel = new Routes_Model();
    return $routesModel->findAll(); // You can add orderBy if needed
}
