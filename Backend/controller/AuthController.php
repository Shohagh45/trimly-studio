<?php

namespace controller;

use Service\AuthService;

class AuthController
{

    private $pdo;
    private $AuthService;

    public function __construct()
    {
        $this->pdo = new \PDO("mysql:host=mysql;dbname=developmentdb", "developer", "secret123");
        $this->AuthService = new AuthService($this->pdo);
    }

    public function login()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $result = $this->AuthService->login($email, $password);

        http_response_code($result['code']);
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $result['message'],
            'token'   => $result['token'] ?? null
        ]);
    }
    public function register()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $result = $this->AuthService->register($email, $password);

        http_response_code($result['code']);
        header('Content-Type: application/json');
        echo json_encode([
            'message' => $result['message']
        ]);
    }
}
