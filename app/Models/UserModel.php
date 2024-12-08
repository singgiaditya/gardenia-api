<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'bio', 'profile_picture', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}
