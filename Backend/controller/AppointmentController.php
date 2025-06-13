<?php

namespace controller;

use Service\AppointmentService;
use Middleware\AuthMiddleware;
use db\Database;

class AppointmentController
{
    private $appointmentService;

    public function __construct()
    {
        $pdo = Database::getConnection();
        $this->appointmentService = new AppointmentService($pdo);
    }

    public function handleCreate()
    {
        $payload = AuthMiddleware::requireAuth();
        $userId = $payload['uid'];

        $input = json_decode(file_get_contents("php://input"), true);
        $date = $input['date'] ?? null;
        $time = $input['time'] ?? null;
        $description = $input['description'] ?? '';

        if (!$date || !$time) {
            http_response_code(400);
            echo json_encode(['message' => 'Date and time are required']);
            return;
        }

        $success = $this->appointmentService->createAppointment($userId, $date, $time, $description);

        if ($success) {
            echo json_encode(['message' => 'Appointment created successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to create appointment']);
        }
    }
    public function handleGetByUser()
{
    $payload = \Middleware\AuthMiddleware::requireAuth();
    $userId = $payload['uid'];

    $appointments = $this->appointmentService->getAppointmentsByUserId($userId);

    header('Content-Type: application/json');
    echo json_encode(['appointments' => $appointments]);
}

}
