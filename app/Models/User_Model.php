<?php

namespace App\Models;

use CodeIgniter\Model;

class User_Model extends Model
{
    protected $table = "users";
    protected $primaryKey = "users_id";
    protected $allowedFields = [ 
        'uuid',
        'name',
        'contact_no',
        'email',
        'password',
        'image',
        'user_type',
        'created_at',
        'updated_at',
    ];
}
