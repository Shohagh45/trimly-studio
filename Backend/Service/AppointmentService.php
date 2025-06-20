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

    public function deleteUserAppointment(int $userId, int $id): array
    {
        $stmt = $this->pdo->prepare("DELETE FROM appointments WHERE id = ? AND user_id = ?");
        $deleted = $stmt->execute([$id, $userId]);

        if ($deleted && $stmt->rowCount()) {
            return ['status' => true, 'message' => 'Appointment deleted'];
        }
        return ['status' => false, 'message' => 'Error deleting appointment'];
    }

    public function deleteAppointmentByAdmin(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM appointments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateAppointmentByAdmin(int $id, string $date, string $time, string $description): bool
    {
        $stmt = $this->pdo->prepare("UPDATE appointments SET date = ?, time = ?, description = ? WHERE id = ?");
        return $stmt->execute([$date, $time, $description, $id]);
    }

    public function getAllAppointments(): array
    {
        $stmt = $this->pdo->query("SELECT a.id, a.date, a.time, a.description, u.email AS user_email FROM appointments a JOIN users u ON a.user_id = u.id ORDER BY a.date, a.time");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAppointmentById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAppointmentsByUserIdAdmin(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT id, date, time, description, created_at FROM appointments WHERE user_id = ? ORDER BY date, time");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
