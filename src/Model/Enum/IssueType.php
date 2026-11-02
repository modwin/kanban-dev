<?php

declare(strict_types=1);

namespace KanbanDev\Model\Enum;

enum IssueType: string
{
    case Bug = 'bug';
    case Feature = 'feature';
    case TechDebt = 'tech_debt';
}
