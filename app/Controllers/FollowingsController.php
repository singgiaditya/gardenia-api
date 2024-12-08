<?php
namespace App\Controllers;

use App\Models\FollowingModel;
use CodeIgniter\RESTful\ResourceController;

class FollowingsController extends ResourceController
{
    protected $modelName = 'App\Models\FollowingModel';
    protected $format = 'json';

    // Follow a user
    public function create()
    {
        $userId = $this->request->user_id; // Dapatkan ID pengguna dari token JWT

        $data = $this->request->getPost();
        $data['user_id'] = $userId;

        // Memastikan bahwa pengguna tidak mengikuti pengguna yang sama dua kali
        if ($this->model->where('user_id', $data['user_id'])->where('following_id', $data['following_id'])->first()) {
            return $this->fail('User is already following this user.');
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    // Retrieve all followings
    public function index()
    {
        $followings = $this->model->findAll();
        return $this->respond(['status' => 'success', 'data' => $followings]);
    }

    // Retrieve followers of a specific user
    public function showFollowers($user_id = null)
    {
        // Validasi jika user_id tidak diberikan
        if (!$user_id) {
            return $this->fail('User ID is required.');
        }

        // Ambil followers berdasarkan user_id
        $followers = $this->model->where('followed_user_id', $user_id)->findAll();

        if ($followers) {
            return $this->respond(['status' => 'success', 'data' => $followers]);
        }

        return $this->failNotFound('No followers found for this user.');
    }

    // Retrieve users that a specific user is following
    public function showFollowing($user_id = null)
    {
        // Validasi jika user_id tidak diberikan
        if (!$user_id) {
            return $this->fail('User ID is required.');
        }

        // Ambil following berdasarkan user_id
        $following = $this->model->where('user_id', $user_id)->findAll();

        if ($following) {
            return $this->respond(['status' => 'success', 'data' => $following]);
        }

        return $this->failNotFound('This user is not following anyone.');
    }

    // Delete a following
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'id' => $id]);
        }

        return $this->failNotFound('Following record not found.');
    }
}
