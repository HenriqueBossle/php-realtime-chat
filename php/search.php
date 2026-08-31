<?php

session_start();

require_once __DIR__ . "/config.php";

$outgoing_id = $_SESSION['unique_id'];
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm'] ?? '');

$sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND (fname LIKE '%{$searchTerm}%' OR lname LIKE '%{$searchTerm}%') ORDER BY fname, lname";

$output = "";

$query = mysqli_query($conn, $sql);
if(mysqli_num_rows($query) > 0){
    while($row = mysqli_fetch_assoc($query)){
        $name = htmlspecialchars($row['fname'] . " " . $row['lname'], ENT_QUOTES, 'UTF-8');
        $image = htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8');
        $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
        $offline = $row['status'] === 'Offline now' ? ' offline' : '';

        $output .= '<a class="user-result" href="chat.php?user_id=' . (int) $row['unique_id'] . '">
            <div class="user-result-avatar">
                <img src="php/images/' . $image . '" alt="Foto de ' . $name . '">
                <span class="status-dot' . $offline . '"></span>
            </div>
            <div class="user-result-details">
                <strong>' . $name . '</strong>
                <span>' . $status . '</span>
            </div>
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </a>';
    }
}else{
    $output .= '<div class="search-empty">
        <div class="search-empty-icon"><i class="fas fa-user-slash" aria-hidden="true"></i></div>
        <strong>Nenhuma pessoa encontrada</strong>
        <span>Tente buscar por outro nome.</span>
    </div>';
}

echo $output;