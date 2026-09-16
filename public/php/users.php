<?php

session_start();

require_once __DIR__ . "/../../vendor/autoload.php";

use App\Config\Database;
use App\Repositories\UserRepository;

if (!isset($_SESSION['unique_id'])) {
    http_response_code(401);
    exit;
}

$conn = Database::connection();

$outgoing_id = $_SESSION['unique_id'];

$userRepository = new UserRepository($conn);

$query = $userRepository->findAllExcept($outgoing_id);

$output = "";

if (mysqli_num_rows($query) == 0) {
    $output .= "No users are available to chat";
} else {
    include_once "data.php";
}

echo $output;