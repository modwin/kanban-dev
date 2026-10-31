<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

const MINUTE_IN_SECONDS = 60;
const HOUR_IN_SECONDS = MINUTE_IN_SECONDS * MINUTE_IN_SECONDS;

class SessionManager
{
    public readonly int $lifespanSeconds;
    public string $cookieName;

    public function __construct(int $hours = 3, string $cookieName = 'session_id')
    {
        $this->cookieName = $cookieName;
        $this->lifespanSeconds = $hours * HOUR_IN_SECONDS;
    }


}