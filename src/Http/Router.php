<?php

declare(strict_types=1);

namespace KanbanDev\Http;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Router
{
    public array $routes = [];

    public function add(Route $route) : void {
        $this->routes[] = $route;
    }

    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        $method = $request->getMethod();
        $uri = parse_url($request->getUri()->getPath(), PHP_URL_PATH) ?? '/';

        foreach ($this->routes as $route) {
            $params = $route->match($method, $uri);
            if ($params !== null) {
                $handler = $route->getHandler();
                return call_user_func($handler, $request, $params);
            }
        }
        return new Response(404, ['Content-Type' => 'application/json'], json_encode(['error' => 'Route not found']));
    }
}
