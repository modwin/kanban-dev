<?php

namespace WPROG2\FinalProject\public;

use PDO;

class Database
{
    public function __construct(private string $host,
                                private string $name,
                                private string $user,
                                private string $password){
    }

    public function connect(): PDO{
        $dsn = "mysql:host{$this->host};dbname={$this->name};charser=utf8";
        return new PDO($dsn, $this->user, $this->password);
    }
}