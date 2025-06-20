<?php
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
    http_response_code(204); // No Content
    exit;
}
$password = 'password123';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Password Hash:\n" . $hash . "\n";
