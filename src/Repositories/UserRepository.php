<?php

namespace App\Repositories;

class UserRepository
{
    public function __construct(
        private \mysqli $conn
    ) {}

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