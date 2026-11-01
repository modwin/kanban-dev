<?php
declare(strict_types=1);

require_once __DIR__ . '/../../../vendor/autoload.php';

use GuzzleHttp\Psr7\ServerRequest;
use WPROG2\FinalProject\Config\EnvSetter;
use WPROG2\FinalProject\Database\Database;
use WPROG2\FinalProject\Http\Route;
use WPROG2\FinalProject\Http\Router;
use WPROG2\FinalProject\Repository\UserRepository;
use WPROG2\FinalProject\Repository\KanbanCardRepository;
use WPROG2\FinalProject\Service\AuthService;
use WPROG2\FinalProject\Service\KanbanCardService;
use WPROG2\FinalProject\Controller\AuthController;
use WPROG2\FinalProject\Controller\KanbanCardController;
use WPROG2\FinalProject\Controller\PageController;

// 1. Environment & Database
EnvSetter::load(__DIR__ . '/../.env');
$pdo = Database::getInstance();

// 2. Repositories
$userRepo = new UserRepository($pdo);
$cardRepo = new KanbanCardRepository($pdo);

// 3. Services
$authService = new AuthService($userRepo);
$cardService = new KanbanCardService($cardRepo);

// 4. Controllers and their dependencies.
$authController = new AuthController($authService);
$cardController = new KanbanCardController($cardService);
$pageController = new PageController();

// 5. Router instantiation with corresponding viable routes.
$router = new Router();
$router->add(new Route('GET', '/', [$pageController, 'home']));
$router->add(new Route('GET', '/login', [$pageController, 'login']));
$router->add(new Route('POST', '/api/auth/register', [$authController, 'register']));
$router->add(new Route('POST', '/api/auth/login', [$authController, 'login']));
$router->add(new Route('POST', '/api/auth/logout', [$authController, 'logout']));
$router->add(new Route('GET',  '/api/auth/me', [$authController, 'me']));

$router->add(new Route('GET',    '/api/cards', [$cardController, 'list']));
$router->add(new Route('POST',   '/api/cards', [$cardController, 'create']));
$router->add(new Route('PATCH',  '/api/cards/{id}/status', [$cardController, 'updateStatus']));
$router->add(new Route('DELETE', '/api/cards/{id}', [$cardController, 'delete']));


$request = ServerRequest::fromGlobals();
$response = $router->dispatch($request);

http_response_code($response->getStatusCode());

foreach ($response->getHeaders() as $name => $values) {
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}
echo $response->getBody();