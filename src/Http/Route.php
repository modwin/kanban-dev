<?php

declare(strict_types=1);

namespace KanbanDev\Http;

class Route
{
    public function __construct(
        private string $method,
        private string $pathPattern,
        private mixed  $handler
    ){}

    public function match(string $method, string $uri): ?array
    {
        if (strtoupper($this->method) !== strtoupper($method)) {
            return null;
        }
        $pattern = '#^' . preg_replace('#\{([a-zA-Z0-9_]+)\}#', '(?P<$1>[^/]+)', $this->pathPattern) . '$#';
        if (preg_match($pattern, $uri, $matches)) {
            return array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
        }

        return null;
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