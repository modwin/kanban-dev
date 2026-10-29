<?php
declare(strict_types=1);

namespace WPROG2\FinalProject\public;

$database = require_once dirname(__DIR__) . '/src/bootstrap.php';

use WPROG2\FinalProject\src\Repository\UserRepository;
use WPROG2\FinalProject\src\Repository\KanbanCardRepository;
use WPROG2\FinalProject\src\Controller\KanbanCardController;

// Databasen som instansierades i bootstrap.php används för mina repositories.
$userRepository = new UserRepository($database);
$cardRepository = new KanbanCardRepository($database);

$cardController = new KanbanCardController($cardRepository);
