<?php

namespace App\Models;

use CodeIgniter\Model;

class Conductor_Model extends Model
{
    protected $table = "conductor_tb";
    protected $primaryKey = "conductor_tb_id";
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'conductor_tb_id',
        'created_at',
        'updated_at',
        'buses_tb_id',
        'users_id',
    ];
    // enable CI timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
}
