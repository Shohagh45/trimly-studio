<?php

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Authorization, Content-Type");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
    http_response_code(204); // No Content
    exit;
}


header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

require_once __DIR__ . '/../../vendor/autoload.php';

use Service\AppointmentService;
use Middleware\AuthMiddleware;
use db\Database;

$payload = AuthMiddleware::requireAuth();

if ($payload['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(['message' => 'Access denied']);
    exit;
}

$pdo = Database::getConnection();
$service = new AppointmentService($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode($service->getAllAppointments());

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $userId = $data['user_id'] ?? null;
    $date = $data['date'] ?? null;
    $time = $data['time'] ?? null;
    $description = $data['description'] ?? '';

    if (!$userId || !$date || !$time) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing required fields']);
        exit;
    }

    $success = $service->createAppointment($userId, $date, $time, $description);
    echo json_encode(['success' => $success]);

} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents("php://input"), true);
    $id = $data['id'] ?? null;
    $date = $data['date'] ?? null;
    $time = $data['time'] ?? null;
    $description = $data['description'] ?? '';

    if (!$id || !$date || !$time) {
        http_response_code(400);
        echo json_encode(['message' => 'Missing required fields']);
        exit;
    }

    $success = $service->updateAppointmentByAdmin($id, $date, $time, $description);
    http_response_code($success ? 200 : 500);
    echo json_encode(['success' => $success]);
    exit;

} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    echo json_encode(['success' => $service->deleteAppointmentByAdmin((int) $_GET['id'])]);

} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
}

