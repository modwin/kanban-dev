<?php

namespace WPROG2\FinalProject\Dto;

use WPROG2\FinalProject\Model\Enum\UserRole;

readonly class UserDto
{
    public function __construct(public ?int $id, public string $username, public UserRole $role)
    {
    }
}