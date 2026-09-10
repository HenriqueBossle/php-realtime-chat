<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__, ['.env']);
$dotenv->load();

$hostname = $_ENV['HOSTNAME'];
$username = $_ENV['USERNAME'];
$password = $_ENV['PASSWORD'];
$dbname = $_ENV['DBNAME'];

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if(!$conn){
    echo "Database connection erro " . mysqli_connect_error();
}