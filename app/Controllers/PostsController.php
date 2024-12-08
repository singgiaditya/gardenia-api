<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class PostsController extends ResourceController
{
    protected $modelName = PostModel::class;
    protected $format    = 'json';

    public function create()
{
    $userId = $this->request->user_id; // Dapatkan ID pengguna dari token JWT

    $data = $this->request->getJson(true);
    $data['user_id'] = $userId;

    if ($this->model->insert($data)) {
        return $this->respondCreated(['message' => 'Post created successfully']);
    }
    return $this->failValidationErrors($this->model->errors());
}



public function update($id = null)
    {
        $data = $this->request->getRawInput();

        if ($this->model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'data' => $data]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    // Delete a post
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'id' => $id]);
        }

        return $this->failNotFound('Post not found.');
    }



    public function index()
    {
        $posts = $this->model->findAll();
        $data = [];
        foreach($posts as $value){
            $user = new UserModel();
            $value['user'] = $user->find($value['user_id']);
            $data[] = $value;
        }
        // foreach ($variable as $key => $value) {
        //     # code...
        // }
        return $this->respond(['posts' => $data]);
    }
}
