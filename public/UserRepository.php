<?php

namespace WPROG2\FinalProject\public;
use PDO;
use PDOException;

class UserRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function addUser() : bool {
        $this->pdo->beginTransaction();

        try {
            // INSERT INTO users...
            $statement = $this->pdo->prepare("INSERT QUERY HERE");

            $statement->execute([
                'username'=>"",
                'password'=>"",
                'role'=>""]);

            $this->pdo->commit();

        }catch (PDOException $e){
            $this->pdo->rollBack();
            throw $e;
        }
        return false;
    }

    public function  findAll() : array {
        return [];
    }
}