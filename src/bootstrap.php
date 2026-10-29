<?php

declare(strict_types=1);

require_once __DIR__ . '/Config/EnvSetter.php';
require_once __DIR__ . '/Database/Database.php';

use WPROG2\FinalProject\Config\EnvSetter;
use WPROG2\FinalProject\Database\Database;

ini_set("display_errors", 1);

EnvSetter::load(__DIR__ . '/../.env', overwrite: true);

return Database::getInstance();