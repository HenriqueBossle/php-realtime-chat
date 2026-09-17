<?php

namespace App\Repositories;

class UserRepository
{
    public function __construct(
        private \mysqli $conn
    ) {}

    public function findById(int $userId): ?array
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users WHERE unique_id = ? LIMIT 1"
        );

        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        return $user ?: null;
    }

    public function countOnlineExcept(int $userId): int
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT COUNT(*) AS online_count
             FROM users
             WHERE status = ?
             AND unique_id != ?"
        );

        $status = 'Online';

        mysqli_stmt_bind_param($stmt, "si", $status, $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return (int) ($row['online_count'] ?? 0);
    }

    public function findAllExcept(int $userId): array
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users
             WHERE NOT unique_id = ?
             ORDER BY user_id DESC"
        );

        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $users = [];
        while ($user = mysqli_fetch_assoc($result)) {
            $users[] = $user;
        }

        return $users;
    }
}