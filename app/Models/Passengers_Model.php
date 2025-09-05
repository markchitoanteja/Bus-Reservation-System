<?php

namespace App\Models;

use CodeIgniter\Model;

class Passengers_Model extends Model
{
    protected $table = "passengers_tb";
    protected $primaryKey = "passengers_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'booking_id',
        'passengers_name',
        'age',
        'gender',
        'travel_status',
        'created_at',
        'updated_at',
        'bookings_tb_id'
    ];

}
