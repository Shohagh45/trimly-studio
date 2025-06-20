<?php

namespace Model;

use PDO;

class UserModel {
  private $pdo;

  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

  public function findByEmail(string $email): ?array {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function create(string $email, string $password, string $role = 'user'): bool {
    $stmt = $this->pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    return $stmt->execute([$email, $password, $role]);
  }
}
