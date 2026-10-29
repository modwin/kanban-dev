<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Http;

class Response
{
    public function __construct(
        private mixed $data = null,
        private int   $statusCode = 200
    )
    {
    }

    public function send(): void
    {
        http_response_code($this->statusCode);
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}