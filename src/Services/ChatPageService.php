<?php

namespace App\Services;

final class ChatPageService
{
    public function __construct(
        private \mysqli $conn
    ) {}

    public function findUserById(int $userId): ?array
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM users WHERE unique_id = ?"
        );

        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        return $row ?: null;
    }
}
