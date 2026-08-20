<?php

session_start();

require_once __DIR__ . "/config.php";

if(!$conn){
    http_response_code(500);
    exit("Database connection failed: " . mysqli_connect_error());
}

$fname = mysqli_real_escape_string($conn, $_POST['fname'] ?? '');
$lname = mysqli_real_escape_string($conn, $_POST['lname'] ?? '');
$email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
$password = mysqli_real_escape_string($conn, $_POST['password'] ?? '');

if(empty($fname) || empty($lname) || empty($email) || empty($password)){
    exit("All input are required!");
}

if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    exit("$email is not a valid email");
}

$sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
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
$extensions = ["jpeg", "png", "jpg"];
$types = ["image/jpeg", "image/jpg", "image/png"];

if(!in_array($img_ext, $extensions, true) || !in_array($img_type, $types, true)){
    exit("Please upload an image file - jpg, jpeg or png");
}

$new_img_name = time() . $img_name;
if(!move_uploaded_file($tmp_name, __DIR__ . "/images/" . $new_img_name)){
    exit("Could not save the image");
}

$ran_id = rand(time(), 100000000);
$status = "Online";
$encrypt_pass = password_hash($password, PASSWORD_DEFAULT);
$insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
    VALUES ({$ran_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");

if(!$insert_query){
    http_response_code(500);
    exit("Database insert failed: " . mysqli_error($conn));
}

$result = mysqli_query($conn, "SELECT unique_id FROM users WHERE email = '{$email}'");
if(!$result || mysqli_num_rows($result) === 0){
    http_response_code(500);
    exit("Could not load the new user");
}

$_SESSION['unique_id'] = mysqli_fetch_assoc($result)['unique_id'];
echo "success";
