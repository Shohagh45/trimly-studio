<?php

namespace Service;

use PDO;
use Service\JWTService;

class AuthService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function login($email, $password)
{
    // Query the user
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check password and respond
    if ($user && password_verify($password, $user['password'])) {
        $token = JWTService::createJWT([
            'uid' => $user['id'],
            'email' => $user['email'],
            'exp' => time() + 3600
        ], getenv('JWT_SECRET'));

        return [
            'status' => true,
            'message' => 'Login successful',
            'token' => $token,
            'code' => 200
        ];
    } else {
        return [
            'status' => false,
            'message' => 'Invalid credentials',
            'code' => 401
        ];
    }
}
public function register(string $email, string $password): array
{
    // Check if user already exists
    $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->fetch()) {
        return [
            'status' => false,
            'message' => 'Email already in use',
            'code' => 409
        ];
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $this->pdo->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->execute([$email, $hashedPassword]);

    return [
        'status' => true,
        'message' => 'User registered successfully',
        'code' => 201
    ];
}


}
