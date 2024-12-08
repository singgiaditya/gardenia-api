<?php 
namespace App\Controllers;

use App\Models\CommentModel;
use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class CommentsController extends ResourceController
{
    protected $modelName = 'App\Models\CommentModel';
    protected $format = 'json';

    // Create a new comment
    public function create()
    {
        $userId = $this->request->user_id; // Dapatkan ID pengguna dari token JWT
        $data = $this->request->getJson(true);
        $data['user_id'] = $userId;


        if ($this->model->insert($data)) {
            return $this->respondCreated(['status' => 'comment success', 'data' => $data]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    // Retrieve all comments
    public function index()
    {
        $comments = $this->model->findAll();
        
        return $this->respond(['status' => 'success', 'comments' => $data]);
    }

    // Retrieve a specific comment
    public function show($id = null)
    {
        $comment = $this->model->find($id);

        if ($comment) {
            return $this->respond(['status' => 'success', 'comment' => $comment]);
        }

        return $this->failNotFound('Comment not found.');
    }
    public function showByPostId($post_id = null)
    {
        // Validasi jika post_id tidak diberikan
        if (!$post_id) {
            return $this->fail('Post ID is required.');
        }

        // Ambil komentar berdasarkan post_id
        $comments = $this->model->where('post_id', $post_id)->findAll();

        $data = [];
        foreach($comments as $value){
            $user = new UserModel();
            $value['user'] = $user->find($value['user_id']);
            $data[] = $value;
        }

        if ($comments) {
            return $this->respond(['status' => 'success', 'comments' => $data]);
        }

        return $this->failNotFound('No comments found for this post.');
    }

    // Update a comment
    public function update($id = null)
    {
        $data = $this->request->getRawInput();

        if ($this->model->update($id, $data)) {
            return $this->respond(['status' => 'success', 'data' => $data]);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    // Delete a comment
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['status' => 'success', 'id' => $id]);
        }

        return $this->failNotFound('Comment not found.');
    }
}
