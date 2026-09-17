<?php

namespace App\Repositories;

class MessageRepository
{
    public function __construct(
        private \mysqli $conn
    ) {}

    public function findLastMessage(int $userId, int $outgoingId): ?array
    {
        $stmt = mysqli_prepare(
            $this->conn,
            "SELECT * FROM messages
             WHERE (
                 (incoming_msg_id = ? AND outgoing_msg_id = ?)
                 OR
                 (outgoing_msg_id = ? AND incoming_msg_id = ?)
             )
             ORDER BY msg_id DESC
             LIMIT 1"
        );

        mysqli_stmt_bind_param(
            $stmt,
            "iiii",
            $userId,
            $outgoingId,
            $userId,
            $outgoingId
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        $message = mysqli_fetch_assoc($result);

        return $message ?: null;
    }
}