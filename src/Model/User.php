<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use JsonSerializable;
use WPROG2\FinalProject\Model\Enum\UserRole;

readonly class User implements JsonSerializable
{
    public function __construct(
        public ?int      $id,
        public string   $username,
        public string   $password,
        public UserRole $role,

    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            username: (string) $data['username'],
            password: (string) ($data['password_hash'] ?? $data['password']),
            role: $data['role'] instanceof UserRole ? $data['role'] : UserRole::from((string) $data['role']),
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'role' => $this->role->value,
        ];
    }

}