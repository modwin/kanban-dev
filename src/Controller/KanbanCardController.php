<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\src\Controller;

use WPROG2\FinalProject\src\Repository\KanbanCardRepository;

class KanbanCardController
{
    public function __construct(private KanbanCardRepository $cardRepository)
    {
    }
}