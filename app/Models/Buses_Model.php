<?php

namespace App\Models;

use CodeIgniter\Model;

class Buses_Model extends Model
{
    protected $table = "buses_tb";
    protected $primaryKey = "buses_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'bus_name',
        'bus_no',
        'bus_type',
        'created_at',
        'updated_at',
    ];
}
