<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use WPROG2\FinalProject\Model\Enum\CardStatus;
use WPROG2\FinalProject\Model\Enum\IssueType;
use WPROG2\FinalProject\Model\Enum\Priority;

final class KanbanCard
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $userId,
        public readonly string $title,
        public readonly ?string $description,
        public readonly CardStatus $status,
        public readonly IssueType $issueType,
        public readonly Priority $priority,
        public readonly int $storyPoints
    ) {}

    /**
     *  Converts a json object to a KanbanCard object.
     * @return self
     */
    public function fromArray() : self {
        return new self(
            $data['id'] ?? null,
            $data['userId'],
            $data['title'],
            $data['description'] ?? null,
            CardStatus::from($data['status']),
            IssueType::from($data['issueType']),
            Priority::from($data['priority']),
            $data['storyPoints']
        );
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function getStatus(): CardStatus
    {
        return $this->status;
    }

    public function getIssueType(): IssueType
    {
        return $this->issueType;
    }

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStoryPoints(): int
    {
        return $this->storyPoints;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

}