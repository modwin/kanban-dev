<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Controller;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use WPROG2\FinalProject\Dto\KanbanCardDto;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use WPROG2\FinalProject\Http\SessionManager;
use WPROG2\FinalProject\Service\KanbanCardService;

class KanbanCardController
{
    public function __construct(private readonly KanbanCardService $cardService){}

    public function list(ServerRequestInterface $request): ResponseInterface
    {
        $userId = SessionManager::getUserId();
        if ($userId === null) {
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['error' => 'Unauthorized']));
        }

        $cards = $this->cardService->getBoardCards($userId);
        return new Response(200, ['Content-Type' => 'application/json'], json_encode(['data' => $cards]));
    }

    public function create(ServerRequestInterface $request): ResponseInterface
    {
        $userId = SessionManager::getUserId();
        if ($userId === null) {
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['error' => 'Unauthorized']));
        }

        try {
            $data = json_decode((string)$request->getBody(), true) ?? [];
            $dto = KanbanCardDto::fromArray($data);
            $card = $this->cardService->createCard($userId, $dto);
            return new Response(201, ['Content-Type' => 'application/json'], json_encode(['data' => $card]));
        } catch (InvalidArgumentException $e) {
            return new Response(422, ['Content-Type' => 'application/json'], json_encode(['error' => $e->getMessage()]));
        }
    }

    public function updateStatus(ServerRequestInterface $request, array $params): ResponseInterface
    {
        $userId = SessionManager::getUserId();
        if ($userId === null) {
            return new Response(401, ['Content-Type' => 'application/json'], json_encode(['error' => 'Unauthorized']));
        }

        $cardId = (int)($params['id'] ?? 0);
        $data = json_decode((string)$request->getBody(), true) ?? [];
        $status = (string)($data['status'] ?? '');

        try {
            $this->cardService->updateCardStatus($cardId, $userId, $status);
            return new Response(200, ['Content-Type' => 'application/json'], json_encode(['message' => 'Status updated']));
        } catch (InvalidArgumentException $e) {
            return new Response(422, ['Content-Type' => 'application/json'], json_encode(['error' => $e->getMessage()]));
        }
    }

}