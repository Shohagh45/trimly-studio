<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");


require_once __DIR__ . '/../vendor/autoload.php';

use controller\AppointmentController;

$controller = new AppointmentController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller->handleCreate();
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller->handleGetByUser();
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}
