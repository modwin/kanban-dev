<?php

namespace WPROG2\FinalProject\src\Http;

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
