<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model;

use WPROG2\FinalProject\Model\Enum\CardStatus;
use WPROG2\FinalProject\Model\Enum\IssueType;
use WPROG2\FinalProject\Model\Enum\Priority;

final readonly class KanbanCard
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
    public function fromArray() : self {
        return new self(
            id: isset($row['id']) ? (int)$row['id'] : null,
            userId: (int)$row['user_id'],
            title: $row['title'],
            description: $row['description'] ?? null,
            status: $row['status'] ?? 'backlog',
            issueType: $row['issue_type'] ?? 'feature',
            priority: $row['priority'] ?? 'P2',
            storyPoints: (int)($row['story_points'] ?? 1),
            branchName: $row['branch_name'] ?? null,
            createdAt: $row['created_at'] ?? null,
            updatedAt: $row['updated_at'] ?? null
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