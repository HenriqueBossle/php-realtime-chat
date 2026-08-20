<?php

    session_start();

    require_once __DIR__ . "/config.php";

    if(!$conn){
        http_response_code(500);
        exit("Database connection failed: " . mysqli_connect_error());
    }

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    

    if(!empty($email) && !empty($password)){
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");

        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            
            $enc_pass = $row['password'];

            if(password_verify($password, $enc_pass)){
                $status = "Online";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']} ");

                if($sql2){
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Went wrong";
                }
            }else{
                echo "EMail or password is incorrect";
            }
        }else{
            echo "$email don t exists";
        }
    }else{
        echo "All input fields are required!";
    }

