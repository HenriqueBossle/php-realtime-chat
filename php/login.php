<?php

    session_start();

    require_once __DIR__ . "/config.php";

    if(!$conn){
        http_response_code(500);
        exit("Database connection failed: " . mysqli_connect_error());
    }

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    

    if(!empty($email) && !empty($password)){
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $sql = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            
            $enc_pass = $row['password'];

            if(password_verify($password, $enc_pass)){
                $status = "Online";
                $stmt2 = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
                $user_id = (int) $row['unique_id'];
                mysqli_stmt_bind_param($stmt2, "si", $status, $user_id);
                $sql2 = mysqli_stmt_execute($stmt2);

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

