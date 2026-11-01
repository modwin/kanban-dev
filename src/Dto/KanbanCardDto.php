<?php

namespace WPROG2\FinalProject\Dto;

use InvalidArgumentException;
use WPROG2\FinalProject\Model\Enum\CardStatus;
use WPROG2\FinalProject\Model\Enum\IssueType;
use WPROG2\FinalProject\Model\Enum\Priority;

final readonly class KanbanCardDto
{
    public function __construct(
        public string $title,
        public ?string $description,
        public CardStatus $status,
        public IssueType $issueType,
        public Priority $priority,
        public int $storyPoints,
        public ?string $branchName
    ) {}

    public static function fromArray(array $data): self
    {
        $title = trim($data['title'] ?? '');
        if ($title === '' || strlen($title) > 255) {
            throw new InvalidArgumentException("Title is required and must be <= 255 characters.");
        }

        $status = CardStatus::tryFrom($data['status'] ?? 'backlog');
        if ($status === null) {
            throw new InvalidArgumentException("Invalid card status.");
        }

        $issueType = IssueType::tryFrom($data['issue_type'] ?? 'feature');
        if ($issueType === null) {
            throw new InvalidArgumentException("Invalid issue type.");
        }

        $priority = Priority::tryFrom($data['priority'] ?? 'P2');
        if ($priority === null) {
            throw new InvalidArgumentException("Invalid priority level.");
        }

        $storyPoints = (int)($data['story_points'] ?? 1);
        if ($storyPoints < 0 || $storyPoints > 100) {
            throw new InvalidArgumentException("Story points must be between 0 and 100.");
        }

        return new self(
            title: $title,
            description: !empty($data['description']) ? trim($data['description']) : null,
            status: $status,
            issueType: $issueType,
            priority: $priority,
            storyPoints: $storyPoints,
            branchName: !empty($data['branch_name']) ? trim($data['branch_name']) : null
        );
    }
}