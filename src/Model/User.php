<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use WPROG2\FinalProject\Model\Enum\UserRole;

readonly class User
{
    public function __construct(
        public int      $id,
        public string   $username,
        public string   $password,
        public UserRole $role,

    ){}

    public static function fromJson(): self
    {
        return new self(
            id: (int) $_POST['id'],
            username: $_POST['username'],
            password: $_POST['password'],
            role: $_POST['role'],
        );
    }

}