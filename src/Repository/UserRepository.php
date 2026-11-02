<?php

declare(strict_types=1);

namespace KanbanDev\Repository;

use PDO;
use PDOException;
use KanbanDev\Model\User;

readonly class UserRepository
{
    public function __construct(private PDO $pdo){}

    public function create(User $user): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO users (username, password_hash, role)
            VALUES (:username, :password, :role)
        ");

        $stmt->execute([
            ':username' => $user->username,
            ':password' => $user->password,
            ':role'     => $user->role->value,
        ]);

        return (int)$this->pdo->lastInsertId();
    }

    public function update(User $user): bool
    {
        $statement = $this->pdo->prepare("
        UPDATE users
        SET password = :password,
            role = :role");

        return $statement->execute([
            'password' => $user->password,
            'role' => $user->role->value]);
    }

    public function deleteByUserId(int $userId): bool
    {
        $statement = $this->pdo->prepare("
        DELETE FROM users
        WHERE id = :userId");

        return $statement->execute([
            'userId' => $userId]);
    }

    public function findByUserId(int $userId): ?User
    {
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $row = $stmt->fetch();

        return $row ? User::fromArray($row) : null;
    }

    public function findByUsername(string $username): ?User
    {
        $stmt = $this->pdo->prepare("SELECT id, username, password_hash, role FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $row = $stmt->fetch();

        return $row ? User::fromArray($row) : null;
    }
}