<?php

session_start();

if(isset($_SESSION['unique_id'])){
    require_once __DIR__ . "/config.php";

    $outgoing_id = (int) $_SESSION['unique_id'];
    $incoming_id = filter_input(INPUT_POST, 'incoming_id', FILTER_VALIDATE_INT);

    if (!$incoming_id) {
        exit;
    }

    $output = "";
    
        $stmt = mysqli_prepare($conn, "SELECT * FROM messages
            LEFT JOIN users ON users.unique_id = messages.outgoing_msg_id 
            WHERE (outgoing_msg_id = ? AND incoming_msg_id = ?)
               OR (outgoing_msg_id = ? AND incoming_msg_id = ?)
            ORDER BY msg_id");
        mysqli_stmt_bind_param($stmt, "iiii", $outgoing_id, $incoming_id, $incoming_id, $outgoing_id);
        mysqli_stmt_execute($stmt);
        $query = mysqli_stmt_get_result($stmt);

    if($query && mysqli_num_rows($query) > 0){
        while($row = mysqli_fetch_assoc($query)){
            if($row['outgoing_msg_id'] == $outgoing_id){
                $output .= '<div class="chat outgoing">
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                            </div>';
            }else{
                $output .= '<div class="chat incoming">
                                <img src="php/images/'. $row['img'] .'" alt="">
                                <div class="details">
                                    <p>'. htmlspecialchars($row['msg']) .'</p>
                                </div>
                            </div>';
            }
        }
    }else{
        $output .= '<div class="text">Você ainda não tem mensagens com esse usuário.</div>';
    }
    echo $output;
}else{
    header("location: ../login.php");
}