CREATE TABLE IF NOT EXISTS users (
                                     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                     username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('developer', 'lead') NOT NULL DEFAULT 'developer',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS tasks (
                                     id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                     user_id BIGINT UNSIGNED NOT NULL,
                                     title VARCHAR(150) NOT NULL,
    description TEXT NULL,
    status ENUM('backlog', 'in_progress', 'code_review', 'testing', 'done') NOT NULL DEFAULT 'backlog',
    issue_type ENUM('bug', 'feature', 'tech_debt') NOT NULL DEFAULT 'feature',
    priority ENUM('P0', 'P1', 'P2', 'P3', 'P4') NOT NULL DEFAULT 'P2',
    story_points INT UNSIGNED NOT NULL DEFAULT 0,
    branch_name VARCHAR(100) NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_tasks_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS attachments (
                                           id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                                           task_id BIGINT UNSIGNED NOT NULL,
                                           filename VARCHAR(255) NOT NULL,
    mime_type VARCHAR(100) NOT NULL,
    image_data MEDIUMBLOB NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_attachments_tasks FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE INDEX idx_tasks_user_status ON tasks (user_id, status);
CREATE INDEX idx_attachments_task_id ON attachments (task_id);