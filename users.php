<?php
    session_start();
    include_once "php/config.php";

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
                            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                            if(mysqli_num_rows($sql) > 0){
                                $row = mysqli_fetch_assoc($sql);

                                $sql_online = mysqli_query($conn, "SELECT COUNT(*) AS online_count FROM users WHERE status = 'Online'");
                                $online_data = mysqli_fetch_assoc($sql_online);
                                $online_count = $online_data['online_count'] - 1 ?? 0;
                            
                            }

                        
                        ?>
                        <div class="avatar-wrap">
                            <img src="php/images/<?php echo $row['img']?>" alt="Foto de perfil">
                            <span class="online-dot"></span>
                        </div>
                        <div class="details">
                            <span><?php echo $row['fname'] . " " . $row['lname'] ?></span>
                            <p><span class="status-indicator"></span><?php echo $row['status']?></p>
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