<?php
require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../src/Config/Database.php";

use App\Config\Database;

if (!isset($conn)) {
    session_start();

    $conn = Database::connection();
}

if (!isset($query)) {
    $outgoing_id = (int) $_SESSION['unique_id'];
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE NOT unique_id = ? ORDER BY user_id DESC");
    mysqli_stmt_bind_param($stmt, "i", $outgoing_id);
    mysqli_stmt_execute($stmt);
    $query = mysqli_stmt_get_result($stmt);
}

if (!isset($outgoing_id)) {
    $outgoing_id = (int) $_SESSION['unique_id'];
}

while($row = mysqli_fetch_assoc($query)){
    $unique_id = (int) $row['unique_id'];
    $stmt2 = mysqli_prepare($conn, "SELECT * FROM messages
         WHERE (
             (incoming_msg_id = ? AND outgoing_msg_id = ?)
             OR
             (outgoing_msg_id = ? AND incoming_msg_id = ?)
         )
         ORDER BY msg_id DESC
         LIMIT 1");
    mysqli_stmt_bind_param($stmt2, "iiii", $unique_id, $outgoing_id, $unique_id, $outgoing_id);
    mysqli_stmt_execute($stmt2);
    $query2 = mysqli_stmt_get_result($stmt2);

    $row2 = mysqli_fetch_assoc($query2);
     if ($row2) {
        $result = $row2['msg'];
    } else {
        $result = "Sem mensagens.";
    }

    $msg = strlen($result) > 28
        ? substr($result, 0, 28) . '...'
        : $result;

    $you = "";

    if ($row2 && $outgoing_id == $row2['outgoing_msg_id']) {
        $you = "You: ";
    }

    $offline = ($row['status'] == "Offline now")
        ? "offline"
        : "";

    $name = htmlspecialchars(
        $row['fname'] . " " . $row['lname'],
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