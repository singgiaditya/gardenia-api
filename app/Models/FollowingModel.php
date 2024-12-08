<?php 
namespace App\Models;

use CodeIgniter\Model;

class FollowingModel extends Model
{
    protected $table = 'following';            // Nama tabel
    protected $primaryKey = 'id';              // Primary key tabel
    protected $allowedFields = ['user_id', 'following_id', 'created_at']; // Kolom yang dapat diisi
}
