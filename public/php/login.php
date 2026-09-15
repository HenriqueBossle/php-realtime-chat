<?php

    session_start();

    require_once __DIR__ . "/../vendor/autoload.php";
    require_once __DIR__ . "/../src/config/database.php";

    use App\Config\Database;

    $conn = Database::connection();

    if (!$conn) {
        logError("Database connection failed: " . mysqli_connect_error());

        http_response_code(500);
        exit("Internal server error.");
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400);
        exit("All input fields are required!");
    }

    $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE email = ?"
    );

    if (!$stmt) {
        logError("Failed to prepare user query: " . mysqli_error($conn));

        http_response_code(500);
        exit("Internal server error.");
    }

    mysqli_stmt_bind_param($stmt, "s", $email);

    if (!mysqli_stmt_execute($stmt)) {
        logError("Failed to execute user query: " . mysqli_stmt_error($stmt));

        http_response_code(500);
        exit("Internal server error.");
    }

    $sql = mysqli_stmt_get_result($stmt);

    if (!$sql) {
        logError("Failed to get query result: " . mysqli_error($conn));

        http_response_code(500);
        exit("Internal server error.");
    }

    if (mysqli_num_rows($sql) === 0) {
        exit("Email or password is incorrect");
    }

    $row = mysqli_fetch_assoc($sql);

    if (!password_verify($password, $row['password'])) {
        exit("Email or password is incorrect");
    }

    $status = "Online";
    $user_id = (int) $row['unique_id'];

    $stmt2 = mysqli_prepare(
        $conn,
        "UPDATE users SET status = ? WHERE unique_id = ?"
    );

    if (!$stmt2) {
        logError("Failed to prepare status update: " . mysqli_error($conn));

        http_response_code(500);
        exit("Internal server error.");
    }

    mysqli_stmt_bind_param($stmt2, "si", $status, $user_id);

    if (!mysqli_stmt_execute($stmt2)) {
        logError("Failed to update user status: " . mysqli_stmt_error($stmt2));

        http_response_code(500);
        exit("Internal server error.");
    }

    $_SESSION['unique_id'] = $row['unique_id'];

    echo "success";