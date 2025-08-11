<?php

namespace App\Models;

use CodeIgniter\Model;

class BusRoutes_Model extends Model
{
    protected $table = "bus_routes_tb";
    protected $primaryKey = "bus_routes_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'dep_time',
        'created_at',
        'updated_at',
        'routes_tb_id',
        'bus_trav_sched_tb_id',
    ];
}

