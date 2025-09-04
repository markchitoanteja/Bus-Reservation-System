<?php

namespace App\Models;

use CodeIgniter\Model;

class Bookings_Model extends Model
{
    protected $table = "bookings_tb";
    protected $primaryKey = "bookings_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'booking_ref',
        'status',
        'no_of_passenger',
        'seats',
        'amount',
        'amount_paid',
        'payment_method',
        'payment_status',
        'created_at',
        'updated_at',
        'bus_routes_tb_id',
        'users_id',
    ];
}
