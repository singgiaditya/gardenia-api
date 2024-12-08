<?php

namespace App\Models;

use CodeIgniter\Model;

class LikeModel extends Model
{
    protected $table = 'likes';              // Nama tabel
    protected $primaryKey = 'id';            // Primary key tabel
    protected $allowedFields = ['post_id', 'user_id', 'reaction', 'created_at']; // Kolom yang dapat diisi
}
