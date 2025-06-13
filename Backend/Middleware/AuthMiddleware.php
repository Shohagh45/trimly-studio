<?php

namespace Middleware;

use Service\JWTService;

class AuthMiddleware
{
    public static function requireAuth(): array
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            http_response_code(401);
            echo json_encode(['message' => 'Missing or invalid Authorization header']);
            exit;
        }

        $token = str_replace('Bearer ', '', $authHeader);
        $payload = JWTService::verifyJWT($token, getenv('JWT_SECRET'));

        if (!$payload) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid or expired token']);
            exit;
        }

        return $payload;
    }

    // Optional: Add this for admin-only routes later
    public static function requireAdmin(): array
    {
        $payload = self::requireAuth();

        if (($payload['role'] ?? '') !== 'admin') {
            http_response_code(403);
            echo json_encode(['message' => 'Forbidden: Admins only']);
            exit;
        }

        return $payload;
    }
}
