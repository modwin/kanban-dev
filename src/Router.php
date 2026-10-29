<?php

namespace WPROG2\FinalProject\src;
use WPROG2\FinalProject\src\Http\Request;
use WPROG2\FinalProject\src\Http\Response;

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
