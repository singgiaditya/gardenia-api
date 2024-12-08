<?php 
namespace App\Controllers;

use App\Models\LikeModel;
use CodeIgniter\RESTful\ResourceController;

class LikesController extends ResourceController
{
    protected $modelName = 'App\Models\LikeModel';
    protected $format = 'json';

    // Create a new like
    public function create()
    {
        $userId = $this->request->user_id; // Dapatkan ID pengguna dari token JWT

        $data = $this->request->getPost();
        $data['user_id'] = $userId;

        // Memastikan bahwa pengguna tidak memberikan like yang sama dua kali
        if ($this->model->where('post_id', $data['post_id'])->where('user_id', $data['user_id'])->first()) {
            return $this->fail('User has already liked this post.');
        }

        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'success', 'data' => $data]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    // Retrieve all likes
    public function index()
    {
        $likes = $this->model->findAll();
        return $this->respond(['status' => 'success', 'data' => $likes]);
    }

    // Retrieve likes for a specific post
    public function show($id = null)
    {
        $likes = $this->model->where('post_id', $id)->findAll();

        if ($likes) {
            return $this->respond(['status' => 'success', 'data' => $likes]);
        }

        return $this->failNotFound('No likes found for this post.');
    }

    // Delete a like
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'id' => $id]);
        }

        return $this->failNotFound('Like not found.');
    }
}
