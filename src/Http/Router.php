<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

class Router
{
    public function __construct(private array $routes = [])
    {
    }
    public function add(Route $route) : void {
        $this->routes[] = $route;
    }

    public function dispatch(Request $request) : Response {
        $validRequest = false;
        if($validRequest) {
            return new Response();
        }
        return new Response();
    }
}
