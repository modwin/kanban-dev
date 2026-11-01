<?php

namespace WPROG2\FinalProject\Dto;

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

}