<?php

namespace App\Models;

use CodeIgniter\Model;

class CommentModel extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['post_id', 'user_id', 'content', 'created_at'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
}
