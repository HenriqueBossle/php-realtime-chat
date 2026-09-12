<?php

session_start();

require_once __DIR__ . "/config.php";

if(!$conn){
    http_response_code(500);
    exit("Database connection failed: " . mysqli_connect_error());
}

$fname = trim($_POST['fname'] ?? '');
$lname = trim($_POST['lname'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if(empty($fname) || empty($lname) || empty($email) || empty($password)){
    exit("All input are required!");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    exit("$email is not a valid email");
}

$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$sql = mysqli_stmt_get_result($stmt);
if(!$sql){
    http_response_code(500);
    exit("Database query failed: " . mysqli_error($conn));
}

if(mysqli_num_rows($sql) > 0){
    exit("$email = This email already exists");
}

if(!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK){
    exit("Please select a valid image");
}

$img_name = $_FILES['image']['name'];
$img_type = $_FILES['image']['type'];
$tmp_name = $_FILES['image']['tmp_name'];
$img_ext = strtolower(pathinfo($img_name, PATHINFO_EXTENSION));
$extensions = ["jpeg", "png", "jpg", "webp"];
$types = ["image/jpeg", "image/jpg", "image/png", "image/webp"];

if(!in_array($img_ext, $extensions, true) || !in_array($img_type, $types, true)){
    exit("Please upload an image file - jpg, jpeg, png or webp");
}

$new_img_name = time() . $img_name;
if(!move_uploaded_file($tmp_name, __DIR__ . "/images/" . $new_img_name)){
    exit("Could not save the image");
}

$ran_id = rand(time(), 100000000);
$status = "Online";
$encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
$stmt = mysqli_prepare($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
    VALUES (?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "issssss", $ran_id, $fname, $lname, $email, $encrypt_pass, $new_img_name, $status);
$insert_query = mysqli_stmt_execute($stmt);

if(!$insert_query){
    http_response_code(500);
    exit("Database insert failed: " . mysqli_error($conn));
}

$stmt = mysqli_prepare($conn, "SELECT unique_id FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
if(!$result || mysqli_num_rows($result) === 0){
    http_response_code(500);
    exit("Could not load the new user");
}

$_SESSION['unique_id'] = mysqli_fetch_assoc($result)['unique_id'];
echo "success";
