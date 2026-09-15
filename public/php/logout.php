<?php
session_start();

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/config/database.php";

use App\Config\Database;

$conn = Database::connection();

// Se não estiver logado, manda pro login
if (!isset($_SESSION['unique_id'])) {
    header("Location: ../login.php");
    exit();
}


if (!$conn) {
    http_response_code(500);
    exit("Database connection failed: " . mysqli_connect_error());
}

// Verifica se o logout_id foi enviado
if (isset($_GET['logout_id'])) {
    $logout_id = filter_input(INPUT_GET, 'logout_id', FILTER_VALIDATE_INT);
    
    // Segurança: só permite deslogar o próprio usuário
    if ($logout_id == $_SESSION['unique_id']) {
        
        $status = "Offline now";
        
        $stmt = mysqli_prepare($conn, "UPDATE users SET status = ? WHERE unique_id = ?");
        mysqli_stmt_bind_param($stmt, "si", $status, $logout_id);
        $sql = mysqli_stmt_execute($stmt);
        
        if ($sql) {
            // Limpa a sessão
            session_unset();
            session_destroy();
            
            // Redireciona para o login
            header("Location: ../login.php");
            exit();
        } else {
            // Em caso de erro no banco, ainda assim desloga
            session_unset();
            session_destroy();
            header("Location: ../login.php");
            exit();
        }
        
    } else {
        // Tentou deslogar outro usuário → volta para users
        header("Location: ../users.php");
        exit();
    }
    
} else {
    // Sem logout_id → volta para users
    header("Location: ../users.php");
    exit();
}
?>