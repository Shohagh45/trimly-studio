<?php

namespace Service;

use PDO;

class AppointmentService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createAppointment(int $userId, string $date, string $time, string $description): bool
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO appointments (user_id, date, time, description) VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([$userId, $date, $time, $description]);
    }
    public function getAppointmentsByUserId(int $userId): array
{
    $stmt = $this->pdo->prepare(
        "SELECT id, date, time, description, created_at 
         FROM appointments 
         WHERE user_id = ? 
         ORDER BY date, time"
    );
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
