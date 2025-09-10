<?php

namespace App\Models;

use CodeIgniter\Model;

class Notifications_Model extends Model
{
    protected $table = "notifications_tb";
    protected $primaryKey = "notifications_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [ 
        'notifications_tb_id',
        'notify_for',
        'which_tb',
        'tb_id',
        'status',
        'created_at',
        'updated_at',
    ];
    // enable CI timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
}
