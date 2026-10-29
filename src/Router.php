<?php

namespace WPROG2\FinalProject\src;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class Router
{
    public function __construct(){
    }

    public function get(string $path) : Response {

        return new Response(200, ["Content-Type" => "application/json"]);
    }

    public function post(string $path) : Response {
        return new Response(200, ["Content-Type" => "application/json"]);

    }

    public function dispatch(Request $request) : Response {
        return new Response(200, ["Content-Type" => "application/json"]);
    }
}
