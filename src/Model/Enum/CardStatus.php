<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model\Enum;

enum CardStatus: string
{
    case Backlog = 'backlog';
    case InProgress = 'in_progress';
    case CodeReview = 'code_review';
    case Testing = 'testing';
    case Done = 'done';
}
