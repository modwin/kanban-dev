<?php

namespace WPROG2\FinalProject\src\Model;

readonly class KanbanCard
{
    public function __construct(
        private string $description,
        private string $status,
        private string $type,
        private string $priority,
        private string $branch
    ){}

    public function getBranch(): string
    {
        return $this->branch;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

}