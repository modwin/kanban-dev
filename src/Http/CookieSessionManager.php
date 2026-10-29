<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\src;
use const WPROG2\FinalProject\public\HOUR_IN_SECONDS;

const MINUTE_IN_SECONDS = 60;
const HOUR_IN_SECONDS = MINUTE_IN_SECONDS * MINUTE_IN_SECONDS;

class CookieSessionManager
{
    private readonly int $lifespanSeconds;
    private string $cookieName;
    private bool $isSecure;

    public function __construct(int $hours = 3, string $cookieName = 'session_id', bool $isSecure = false)
    {
        $this->cookieName = $cookieName;
        $this->lifespanSeconds = $hours * HOUR_IN_SECONDS;
        $this->isSecure = $isSecure; // 1. Tilldela värdet till egenskapen
    }
}