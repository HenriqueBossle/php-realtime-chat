<?php

session_start();

if (isset($_SESSION['unique_id'])) {

    require_once __DIR__ . "/config.php";

    $outgoing_id = $_SESSION['unique_id'];

    $incoming_id = filter_input(
        INPUT_POST,
        'incoming_id',
        FILTER_VALIDATE_INT
    );

    $message = trim($_POST['message'] ?? '');

    if (!$incoming_id || $message === '') {
        exit;
    }

    $stmt = mysqli_prepare(
        $conn,
        'INSERT INTO messages
        (incoming_msg_id, outgoing_msg_id, msg)
        VALUES (?, ?, ?)'
    );

    mysqli_stmt_bind_param(
        $stmt,
        'iis',
        $incoming_id,
        $outgoing_id,
        $message
    );

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);

} else {

    header("Location: ../login.php");
    exit;
}