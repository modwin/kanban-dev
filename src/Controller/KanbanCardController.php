<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Controller;

use WPROG2\FinalProject\Repository\KanbanCardRepository;

class KanbanCardController
{
    public function __construct(private KanbanCardRepository $cardRepository)
    {
    }
}