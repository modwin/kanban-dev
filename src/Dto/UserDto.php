<?php

namespace KanbanDev\Dto;

use KanbanDev\Model\Enum\UserRole;

readonly class UserDto
{
    public function __construct(public ?int $id, public string $username, public UserRole $role)
    {
    }
}