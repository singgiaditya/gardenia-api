<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController
{
    protected $modelName = UserModel::class;
    protected $format    = 'json';

    public function register()
{
    $data = $this->request->getJSON(true); // Konversi ke array
    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);

    if ($this->model->insert($data)) {
        return $this->respondCreated(['message' => 'User registered successfully']);
    }
    return $this->failValidationErrors($this->model->errors());
}

public function login()
{
    $data = $this->request->getJSON(true); // Konversi ke array
    $email = $data['email'];
    $password = $data['password'];

    $user = $this->model->where('email', $email)->first();
    if ($user && password_verify($password, $user['password'])) {
        $token = createJWT($user['id']); // Fungsi JWT
        return $this->respond([
            'message' => 'Login successful',
            'token'   => $token,
            'user'    => $user
        ]);
    }
    return $this->failUnauthorized('Invalid credentials');
}


}
