<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

use WPROG2\FinalProject\Dto\UserDto;

const MINUTE_IN_SECONDS = 60;
const HOUR_IN_SECONDS = MINUTE_IN_SECONDS * MINUTE_IN_SECONDS;
const LIFESPAN_SECONDS = 3 * HOUR_IN_SECONDS;

/**
 * Class for PHP's session functions and session/login management.
 */
class SessionManager
{

    public static function start_session(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => LIFESPAN_SECONDS,
                'path' => '/',
                'domain' => null,
                'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
                'httponly' => true,
                'samesite' => 'Strict'
            ]);
            session_start();
        }
    }

    public static function login(UserDto $userDto): void
    {
        self::start_session();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userDto->id;
        $_SESSION['username'] = $userDto->username;
        $_SESSION['role'] = $userDto->role;
    }

    public static function logout(): void
    {
        self::start_session();
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        session_destroy();
    }

    public static function getAuthenticatedUser(): ?UserDto
    {
        self::start_session();
        if (isset($_SESSION['user_id'])){

            return new UserDto($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
        }
        return null;
    }

    public static function isAuthenticated(): bool
    {
        return self::getAuthenticatedUser() !== null;
    }

}