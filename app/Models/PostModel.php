<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'title', 'content', 'image_url', 'views_count', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}
