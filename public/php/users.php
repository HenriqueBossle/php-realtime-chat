<?php

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";
require_once __DIR__ . "/../../src/config/database.php";

use App\Config\Database;

$conn = Database::connection();

$outgoing_id = $_SESSION['unique_id'];

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE NOT unique_id = ? ORDER BY user_id DESC");

mysqli_stmt_bind_param($stmt, "i", $outgoing_id);

mysqli_stmt_execute($stmt);

$query = mysqli_stmt_get_result($stmt);

$output = "";


if (mysqli_num_rows($query) == 0) {
    $output .= "No users are available to chat";
} else { 
    include_once "data.php";
}

echo $output;

