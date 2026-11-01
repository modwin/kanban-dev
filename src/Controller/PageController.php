<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Controller;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use WPROG2\FinalProject\Http\SessionManager;

final class PageController
{
    public function home(): ResponseInterface
    {
        if (!SessionManager::isAuthenticated()) {
            return new Response(302, ['Location' => '/login']);
        }

        return $this->render('index.html');
    }

    public function login(): ResponseInterface
    {
        if (SessionManager::isAuthenticated()) {
            return new Response(302, ['Location' => '/']);
        }

        return $this->render('login.html');
    }

    private function render(string $page): ResponseInterface
    {
        $body = file_get_contents(__DIR__ . '/../../templates/' . $page);

        return new Response(200, ['Content-Type' => 'text/html; charset=utf-8'], $body);
    }
}