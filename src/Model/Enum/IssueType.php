<?php

namespace WPROG2\FinalProject\Model\Enum;

enum IssueType: string
{
    case Bug = 'bug';
    case Feature = 'feature';
    case TechDebt = 'tech_debt';
}
