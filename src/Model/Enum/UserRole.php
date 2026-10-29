<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Model\Enum;

enum UserRole: string
{
    case Developer = 'developer';
    case Lead = 'lead';
}
