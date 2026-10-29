<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Repository;

use PDO;
use PDOException;
use WPROG2\FinalProject\Model\User;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(User $user): bool
    {
        $this->pdo->beginTransaction();

        try {
            // INSERT INTO users...
            $statement = $this->pdo->prepare("INSERT QUERY HERE");

            $statement->execute([
                'username' => "",
                'password' => "",
                'role' => ""]);

            $this->pdo->commit();

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
        return false;
    }

    public function findAll(): array
    {
        return [];
    }
}