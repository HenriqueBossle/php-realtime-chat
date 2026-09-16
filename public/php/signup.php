<?php

    session_start();

    require_once __DIR__ . "/../../vendor/autoload.php";
    require_once __DIR__ . "/../../src/config/database.php";

    use App\Config\Database;

    $conn = Database::connection();

    require_once __DIR__ . "/logger.php";

    if(!$conn){
        logError("Database connection failed: " . mysqli_connect_error());

        http_response_code(500);
        exit("Internal server error");
    }

    $fname = trim($_POST['fname'] ?? '');
    $lname = trim($_POST['lname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if(empty($fname) || empty($lname) || empty($email) || empty($password)){
        http_response_code(400);
        exit("All input are required!");
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        exit("$email is not a valid email");
    }

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");

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

    if(!$sql){
        logError("Failed to get query result: " . mysqli_error($conn));

        http_response_code(500);
        exit("Internal server error.");
    }

    if (mysqli_num_rows($sql) > 0) {
        exit("Email already registered");
    }

    mysqli_stmt_close($stmt);

    if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK){
        exit("Please select a valid image");
    }

    $tmp_name = $_FILES['image']['tmp_name'];
    $img_name = $_FILES['image']['name'];

    $img_info = getimagesize($tmp_name);

    if($img_info === false){
        exit("O upload não foi de uma imagem válida");
    }

    $mime_real = $img_info['mime'];

    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/avif' => 'avif'
    ];

    if (!isset($extensions[$mime_real])) {
        exit("Tipo de imagem não válido, são aceitos apenas JPG, PNG, WEBP ou AVIF");
    }

    $img_ext = $extensions[$mime_real];

    $new_img_name = bin2hex(random_bytes(16)) . "." . $img_ext;

    $image_dir = __DIR__ . "/images/";

    if (!is_dir($image_dir) && !mkdir($image_dir, 0755, true)) {
        logError("Failed to create image directory: " . $image_dir);

        http_response_code(500);
        exit("Internal server error.");
    }

    $image_path = $image_dir . $new_img_name;

    if (!move_uploaded_file($tmp_name, $image_path)) {
        exit("Não foi possivel salvar a imagem");
    }

    $ran_id = random_int(100000000, 999999999);
    $status = "Online";
    $encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status) VALUES (?, ?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        unlink($image_path);

        logError("Failed to prepare insert query: " . mysqli_error($conn));

        http_response_code(500);
        exit("Internal server error.");
    }

    mysqli_stmt_bind_param($stmt, "issssss", $ran_id, $fname, $lname, $email, $encrypt_pass, $new_img_name, $status);

    $insert_query = mysqli_stmt_execute($stmt);

    if (!$insert_query) {
        logError("Failed to insert user: " . mysqli_stmt_error($stmt));

        unlink($image_path);

        http_response_code(500);
        exit("Internal server error.");
    }

    mysqli_stmt_close($stmt);

    $_SESSION['unique_id'] = $ran_id;

    echo "success";
