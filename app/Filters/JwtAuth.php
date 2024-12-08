<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');
        if (!$authHeader || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            return Services::response()->setJSON([
                'status'  => 'error',
                'message' => 'Access denied. No token provided.',
            ])->setStatusCode(401);
        }

        $token = $matches[1];
        $decoded = decodeJWT($token);

        if (!$decoded) {
            return Services::response()->setJSON([
                'status'  => 'error',
                'message' => 'Invalid or expired token.',
            ])->setStatusCode(401);
        }

        // Tambahkan ID pengguna ke request untuk digunakan di controller
        $request->user_id = $decoded->sub;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah respons
    }
}
