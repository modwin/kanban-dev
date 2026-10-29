<?php

namespace WPROG2\FinalProject\src\Http;

class Request
{
    private string $method;
    private string $uri;
    private array $queryParams;
    private mixed $body;

    public function __construct()
    {

    }

    public function capture(): self
    {
        return new self();
    }
}