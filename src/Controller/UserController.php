<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Controller;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use WPROG2\FinalProject\Repository\UserRepository;

class UserController
{

    public function __construct(UserRepository $userRepository)
    {

    }

    public function getUser(Request $request): Response
    {
        return new Response(200);
    }

    public function getAllUsers(Request $request): Response
    {
        return new Response(200);
    }

    public function createUser(Request $request): Response
    {
        return new Response(200);
    }

    public function updateUser(Request $request): Response
    {
        return new Response(200);
    }

    public function deleteUser(Request $request): Response
    {
        return new Response(200);
    }
}