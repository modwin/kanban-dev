<?php

namespace KanbanDev\Service;

use InvalidArgumentException;
use KanbanDev\Dto\KanbanCardDto;
use KanbanDev\Model\Enum\CardStatus;
use KanbanDev\Model\KanbanCard;
use KanbanDev\Repository\KanbanCardRepository;

readonly class KanbanCardService
{
    public function __construct(private KanbanCardRepository $cardRepository){}

    public function getBoardCards(int $userId): array
    {
        return $this->cardRepository->findAllByUserId($userId);
    }

    public function createCard(int $userId, KanbanCardDto $dto): KanbanCard
    {
        $card = KanbanCard::fromDto($userId, $dto);
        $insertedId = $this->cardRepository->create($card);
        return KanbanCard::fromDto($userId, $dto, $insertedId);
    }

    public function updateCardStatus(int $cardId, int $userId, string $status): void
    {
        $statusEnum = CardStatus::tryFrom($status);
        if ($statusEnum === null) {
            throw new InvalidArgumentException("Invalid card status: {$status}");
        }

        $this->cardRepository->updateStatus($cardId, $userId, $statusEnum->value);
    }

    public function deleteCard(int $cardId, int $userId): bool
    {
        return $this->cardRepository->delete($cardId, $userId);
    }
}