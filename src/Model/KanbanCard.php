<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use JsonSerializable;
use WPROG2\FinalProject\Model\Enum\CardStatus;
use WPROG2\FinalProject\Model\Enum\IssueType;
use WPROG2\FinalProject\Model\Enum\Priority;
use WPROG2\FinalProject\Dto\KanbanCardDto;

readonly class KanbanCard implements JsonSerializable
{
    public function __construct(
        public ?int       $id,
        public int        $userId,
        public string     $title,
        public ?string    $description,
        public CardStatus $status,
        public IssueType  $issueType,
        public Priority   $priority,
        public int        $storyPoints,
        public ?string    $branchName,
        public ?string    $createdAt = null,
        public ?string    $updatedAt = null
    ) {}


    /**
     *  Converts a json object to a KanbanCard object.
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: isset($data['id']) ? (int)$data['id'] : null,
            userId: (int)$data['user_id'],
            title: (string)$data['title'],
            description: $data['description'] ?? null,
            status: CardStatus::from($data['status'] ?? 'backlog'),
            issueType: IssueType::from($data['issue_type'] ?? 'feature'),
            priority: Priority::from($data['priority'] ?? 'P2'),
            storyPoints: (int)($data['story_points'] ?? 0),
            branchName: $data['branch_name'] ?? null,
            createdAt: $data['created_at'] ?? null,
            updatedAt: $data['updated_at'] ?? null,
        );
    }

    public static function fromDto(int $userId, KanbanCardDto $dto, ?int $id = null): self
    {
        return new self(
            id: $id,
            userId: $userId,
            title: $dto->title,
            description: $dto->description,
            status: $dto->status,
            issueType: $dto->issueType,
            priority: $dto->priority,
            storyPoints: $dto->storyPoints,
            branchName: $dto->branchName,
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status->value,
            'issue_type' => $this->issueType->value,
            'priority' => $this->priority->value,
            'story_points' => $this->storyPoints,
            'branch_name' => $this->branchName,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}