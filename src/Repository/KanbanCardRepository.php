<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\Repository;

use PDO;
use PDOException;
use WPROG2\FinalProject\Model\KanbanCard;

readonly class KanbanCardRepository
{
    public function __construct(private PDO $pdo){}

    public function create(KanbanCard $card): int
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("
            INSERT INTO tasks (user_id, title, description, status, issue_type, priority, story_points, branch_name)
            VALUES (:user_id, :title, :description, :status, :issue_type, :priority, :story_points, :branch_name)
        ");

            $stmt->execute([
                ':user_id'      => $card->userId,
                ':title'        => $card->title,
                ':description'  => $card->description,
                ':status'       => $card->status->value,
                ':issue_type'   => $card->issueType->value,
                ':priority'     => $card->priority->value,
                ':story_points' => $card->storyPoints,
                ':branch_name'  => $card->branchName,
            ]);
            $this->pdo->commit();

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }

        return (int)$this->pdo->lastInsertId();
    }

    public function delete(int $id, int $userId): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM tasks WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([':id' => $id, ':user_id' => $userId]);
    }

    public function update(int $id, int $userId, KanbanCard $card): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE tasks
            SET title = :title,
                description = :description,
                status = :status, 
                priority = :priority, 
                issue_type = :issue_type, 
                story_points = :story_points,
                branch_name = :branch_name,
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id AND user_id = :user_id
        ");

        return $stmt->execute([
            ':title'        => $card->title,
            ':description'  => $card->description,
            ':status'       => $card->status->value,
            ':priority'     => $card->priority->value,
            ':issue_type'   => $card->issueType->value,
            ':story_points' => $card->storyPoints,
            ':branch_name'  => $card->branchName,
            ':id'           => $id,
            ':user_id'      => $userId,
        ]);
    }

    public function findAllByUserId(int $userId): array
    {
        $stmt = $this->pdo->prepare("
            SELECT id, user_id, title, description, status, issue_type, priority, story_points, branch_name, created_at, updated_at
            FROM tasks
            WHERE user_id = :user_id
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);

        $cards = [];
        while ($row = $stmt->fetch()) {
            $cards[] = KanbanCard::fromArray($row);
        }
        return $cards;
    }
}