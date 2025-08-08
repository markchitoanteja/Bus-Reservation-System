<?php

namespace App\Models;

use CodeIgniter\Model;

class Schedules_Model extends Model
{
    protected $table = "bus_trav_sched_tb";
    protected $primaryKey = "bus_trav_sched_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'date',
        'dep_time',
        'created_at',
        'updated_at',
        'buses_tb_id',
        'routes_tb_id',
    ];
}
