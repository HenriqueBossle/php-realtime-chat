<?php
    session_start();
    require_once __DIR__ . "/php/config.php";

    if(!isset($_SESSION['unique_id'])){
        header("location: login.php");
    }
?>

<?php

include_once "header.php";

?>
    <body>
    
        <div class="wrapper">
            <section class="users">
                <header>
                    <div class="content">
                        <?php 
                            $row = null;
                            $online_count = 0;
                            $user_id = (int) $_SESSION['unique_id'];
                            $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE unique_id = ?");
                            mysqli_stmt_bind_param($stmt, "i", $user_id);
                            mysqli_stmt_execute($stmt);
                            $sql = mysqli_stmt_get_result($stmt);
                            if(mysqli_num_rows($sql) > 0){
                                $row = mysqli_fetch_assoc($sql);

                                $stmt_online = mysqli_prepare($conn, "SELECT COUNT(*) AS online_count FROM users WHERE status = ?");
                                $online_status = "Online";
                                mysqli_stmt_bind_param($stmt_online, "s", $online_status);
                                mysqli_stmt_execute($stmt_online);
                                $sql_online = mysqli_stmt_get_result($stmt_online);
                                $online_data = mysqli_fetch_assoc($sql_online);
                                $online_count = max(0, (int) ($online_data['online_count'] ?? 0) - 1);
                            
                            } else {
                                header("location: login.php");
                                exit;
                            }

                        
                        ?>
                        <div class="avatar-wrap">
                            <img src="php/images/<?php echo htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8')?>" alt="Foto de perfil">
                            <span class="online-dot"></span>
                        </div>
                        <div class="details">
                            <span><?php echo htmlspecialchars($row['fname'] . " " . $row['lname'], ENT_QUOTES, 'UTF-8')?></span>
                            <p><span class="status-indicator"></span><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8')?></p>
                        </div>
                        <a class="logout" href="php/logout.php?logout_id=<?php echo $_SESSION['unique_id']; ?>" aria-label="Sair">
                            <i class="fas fa-arrow-right-from-bracket"></i>
                        </a>
                    </div>
                </header>

                <div class="users-heading">
                    <div>
                        <span class="eyebrow">Sua rede</span>
                        <h1>Conversas</h1>
                    </div>
                    <span class="conversation-count">Você mais <?php echo $online_count; ?> pessoas estão online</span>
                </div>

                <div class="search">
                    <button><i class="fas fa-search" aria-hidden="true"></i></button>
                    <input type="text" placeholder="Buscar pessoas..." aria-label="Buscar pessoas">
                </div>
                <div class="users-list">
                    <div class="empty-users">
                        <div class="empty-icon"><i class="far fa-comments"></i></div>
                        <h2>Nenhuma conversa ainda</h2>
                        <p>Quando alguém entrar na sua rede, suas conversas aparecerão aqui.</p>
                    </div>
                </div>
            </section>
        </div>

        <script type="text/javascript" src="js/users.js"></script>

    </body>

</html>