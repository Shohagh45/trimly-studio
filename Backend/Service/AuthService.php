<?php

namespace Service;

use PDO;
use Service\JWTService;
use Model\UserModel;

class AuthService
{
    private $userModel;

    public function __construct($pdo)
    {
        $this->userModel = new UserModel($pdo);
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $token = JWTService::createJWT([
                'uid' => $user['id'],
                'email' => $user['email'],
                'role' => $user['role'], 
                'exp' => time() + 3600
            ], getenv('JWT_SECRET'));

            return [
                'status' => true,
                'message' => 'Login successful',
                'token' => $token,
                'role' => $user['role'],
                'code' => 200
            ];
        }

        return [
            'status' => false,
            'message' => 'Invalid credentials',
            'code' => 401
        ];
    }

    public function register(string $email, string $password): array
    {
        if ($this->userModel->findByEmail($email)) {
            return [
                'status' => false,
                'message' => 'Email already in use',
                'code' => 409
            ];
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->userModel->create($email, $hashedPassword); 

        return [
            'status' => true,
            'message' => 'User registered successfully',
            'code' => 201
        ];
    }
}
