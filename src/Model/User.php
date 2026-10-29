<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use WPROG2\FinalProject\Model\Enum\UserRole;

readonly class User
{
    public function __construct(
        private int    $id,
        private string $username,
        private string $password,
        private UserRole $role,

    ){}

    public function getRole(): UserRole
    {
        return $this->role;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }


}