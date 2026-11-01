<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

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

    public static function login(int $user_id, string $role): void
    {
        self::start_session();
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['role'] = $role;
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

    public static function getUserId(): ?int
    {
        self::start_session();
        return isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    }

    public static function isAuthenticated(): bool
    {
        return self::getUserId() !== null;
    }

}