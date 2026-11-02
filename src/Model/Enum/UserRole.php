<?php

declare(strict_types=1);

namespace KanbanDev\Model\Enum;

enum UserRole: string
{
    case Developer = 'developer';
    case Lead = 'lead';
}
