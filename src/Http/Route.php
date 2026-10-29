<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

class Route
{
    public function __construct(
        private string $method,
        private string $pathPattern,
        private mixed  $handler
    )
    {
    }

    public function matches(string $metod, string $uri): bool
    {
        if (strtoupper($this->method) !== strtoupper($metod)) {
            return false;
        }
        $pattern = '#^' . preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[a-zA-Z0-9_]+)', $this->pathPattern) . '$#';
        return (bool)preg_match($pattern, $uri);
    }

    public function getHandler(): mixed
    {
        return $this->handler;
    }

    public function getPathPattern(): string
    {
        return $this->pathPattern;
    }
}