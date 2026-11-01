<?php

namespace WPROG2\FinalProject\Service;

use InvalidArgumentException;
use RuntimeException;
use WPROG2\FinalProject\Http\SessionManager;
use WPROG2\FinalProject\Model\Enum\UserRole;
use WPROG2\FinalProject\Model\User;
use WPROG2\FinalProject\Repository\UserRepository;

class AuthService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function register(string $username, string $password, UserRole $role = UserRole::Developer): User
    {
        if (strlen($username) < 3 || strlen($password) < 6) {
            throw new InvalidArgumentException("Username must be >= 3 chars and password >= 6 chars.");
        }

        if ($this->userRepository->findByUsername($username) !== null) {
            throw new RuntimeException("Username already exists.");
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $user = new User(
            id: null,
            username: $username,
            password: $passwordHash,
            role: $role
        );

        $id = $this->userRepository->create($user);
        return new User(id: $id, username: $username, password: $passwordHash, role: $role);
    }

    public function authenticate(string $username, string $password): User
    {
        $user = $this->userRepository->findByUsername($username);
        if ($user === null || !password_verify($password, $user->password)) {
            throw new InvalidArgumentException("Invalid username or password.");
        }

        SessionManager::login($user->id, $user->role->value);
        return $user;
    }
}