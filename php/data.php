<?php

session_start();

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/users.php";

if(!$conn){
    http_response_code(500);
    exit("Database connection failed: " . mysqli_connect_error());
}

while($row = mysqli_fetch_assoc($query)){
    $unique_id = (int) $row['unique_id'];
    $sql2 = "SELECT * FROM messages
         WHERE (
             (incoming_msg_id = {$unique_id} AND outgoing_msg_id = {$outgoing_id})
             OR
             (outgoing_msg_id = {$unique_id} AND incoming_msg_id = {$outgoing_id})
         )
         ORDER BY msg_id DESC
         LIMIT 1";

    $query2 = mysqli_query($conn, $sql2);
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