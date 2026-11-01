<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Repository;

use PDO;
use PDOException;
use WPROG2\FinalProject\Model\User;

readonly class UserRepository
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function create(User $user): int
    {
        $this->pdo->beginTransaction();

        try {
            $statement = $this->pdo->prepare("
            INSERT INTO users (username, password, role)
            VALUES (:username, :password, :role)");

            $statement->execute([
                'username' => $user->username,
                'password' => $user->password,
                'role' => $user->role]);

            $this->pdo->commit();

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
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

    public function findByUserId($userId): bool
    {
        $statement = $this->pdo->prepare("
        SELECT * FROM users
        WHERE id = :userId");

        return $statement->execute([
            'userId' => $userId]);
    }
}