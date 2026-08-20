<?php

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "php_realtime_chat";

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if(!$conn){
    echo "Database connection erro " . mysqli_connect_error();
}