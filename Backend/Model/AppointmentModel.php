<?php

namespace Model;

use PDO;

class AppointmentModel
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(int $userId, string $date, string $time, string $description): bool
    {
        $stmt = $this->pdo->prepare("INSERT INTO appointments (user_id, date, time, description) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$userId, $date, $time, $description]);
    }

    public function getByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT a.*, u.email AS user_email FROM appointments a JOIN users u ON a.user_id = u.id ORDER BY a.date DESC, a.time DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM appointments WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function update(int $id, string $date, string $time, string $description): bool
    {
        $stmt = $this->pdo->prepare("UPDATE appointments SET date = ?, time = ?, description = ? WHERE id = ?");
        return $stmt->execute([$date, $time, $description, $id]);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
} 
