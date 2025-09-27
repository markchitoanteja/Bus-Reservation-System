<?php

namespace App\Models;

use CodeIgniter\Model;

class Routes_Model extends Model
{
    protected $table = "routes_tb";
    protected $primaryKey = "routes_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'origin',
        'destination',
        'with_cr_fare',
        'without_cr_fare',
        'created_at',
        'updated_at',
    ];
}
