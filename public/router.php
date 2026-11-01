<?php

declare(strict_types=1);

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';
$requestedFile = realpath(__DIR__ . DIRECTORY_SEPARATOR . ltrim($requestPath, '/\\'));
$publicRoot = realpath(__DIR__);

if (
    $requestPath !== '/'
    && $requestedFile !== false
    && $publicRoot !== false
    && str_starts_with($requestedFile, $publicRoot . DIRECTORY_SEPARATOR)
) {
    return false;
}

require __DIR__ . '/index.php';