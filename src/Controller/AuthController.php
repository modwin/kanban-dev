<?php

namespace WPROG2\FinalProject\Controller;

use Exception;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use WPROG2\FinalProject\Http\SessionManager;
use WPROG2\FinalProject\Model\Enum\UserRole;
use WPROG2\FinalProject\Service\AuthService;

class AuthController
{

    public function __construct(private readonly AuthService $authService) {}

    public function register(ServerRequestInterface $request): ResponseInterface
    {
        $body = json_decode((string)$request->getBody(), true) ?? [];
        $username = trim($body['username'] ?? '');
        $password = (string)($body['password'] ?? '');
        $role = UserRole::tryFrom($body['role'] ?? 'developer') ?? UserRole::Developer;

        try {
            $user = $this->authService->register($username, $password, $role);
            return new Response(201, ['Content-Type' => 'application/json'], json_encode(['data' => $user]));
        } catch (InvalidArgumentException $e) {
            return new Response(422, ['Content-Type' => 'application/json'], json_encode(['error' => $e->getMessage()]));
        } catch (Exception $e) {
            return new Response(400, ['Content-Type' => 'application/json'], json_encode(['error' => $e->getMessage()]));
        }
    }

    public function login(ServerRequestInterface $request): ResponseInterface
    {
        $body = json_decode((string)$request->getBody(), true) ?? [];
        $username = trim($body['username'] ?? '');
        $password = (string)($body['password'] ?? '');

        try {
            $user = $this->authService->authenticate($username, $password);
            return new Response(200, ['Content-Type' => 'application/json'], json_encode(['data' => $user]));
        } catch (Exception $e) {
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['error' => 'Invalid username or password']));
        }
    }

}