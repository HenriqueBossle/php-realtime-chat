<?php

use App\Config\Database;
use App\Repositories\MessageRepository;


if (!isset($conn)) {
    $conn = Database::connection();
}

if (!isset($outgoing_id)) {
    $outgoing_id = (int) ($_SESSION['unique_id'] ?? 0);
}

if (!isset($messageRepository)) {
    $messageRepository = new MessageRepository($conn);
}

if (!isset($output)) {
    $output = '';
}

foreach (($users ?? []) as $row) {
    $unique_id = (int) $row['unique_id'];
    $lastMessage = $messageRepository->findLastMessage($unique_id, $outgoing_id);

    $result = $lastMessage['msg'] ?? 'Sem mensagens.';

    $msg = strlen($result) > 28
        ? substr($result, 0, 28) . '...'
        : $result;

    $you = '';

    if ($lastMessage && $outgoing_id == $lastMessage['outgoing_msg_id']) {
        $you = 'You: ';
    }

    $offline = ($row['status'] == 'Offline now')
        ? 'offline'
        : '';

    $name = htmlspecialchars(
        $row['fname'] . ' ' . $row['lname'],
        ENT_QUOTES,
        'UTF-8'
    );

    $image = htmlspecialchars(
        $row['img'],
        ENT_QUOTES,
        'UTF-8'
    );

    $output .= '
        <a href="chat.php?user_id=' . $unique_id . '">
            <div class="content">
                <img src="php/images/' . $image . '" alt="">
                <div class="details">
                    <span>' . $name . '</span>
                    <p>' . $you . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</p>
                </div>
            </div>

            <div class="status-dot ' . $offline . '">
                <i class="fas fa-circle"></i>
            </div>
        </a>
    ';
}