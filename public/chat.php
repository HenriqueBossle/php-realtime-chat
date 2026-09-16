<?php
session_start();

    require_once __DIR__ . "/../vendor/autoload.php";
    require_once __DIR__ . "/../src/config/database.php";

    use App\Config\Database;

    $conn = Database::connection();


if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
    exit;
}
?>

<?php
include_once "header.php";
?>

<body>

<div class="wrapper">
    <section class="chat-area">
        <header>

            <?php 
                if(!isset($_GET['user_id']) || !ctype_digit($_GET['user_id'])){
                    header("location: users.php");
                    exit;
                }
                $id_user = (int) $_GET['user_id'];

                $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE unique_id = ?");
                mysqli_stmt_bind_param($stmt, "i", $id_user);
                mysqli_stmt_execute($stmt);
                $sql = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($sql) > 0){
                    $row = mysqli_fetch_assoc($sql);
                    $user_id = $row['unique_id'];
                }else{
                    header("location: users.php");
                    exit;
                }

            ?>

            <a href="users.php" class="back-icon" aria-label="Voltar"><i class="fas fa-arrow-left"></i></a>
            <div class="avatar-wrap">
                <img src="php/images/<?php echo htmlspecialchars($row['img'], ENT_QUOTES, 'UTF-8')?>" alt="Foto de perfil de <?php echo htmlspecialchars($row['fname'] . ' ' . $row['lname'], ENT_QUOTES, 'UTF-8')?>">
                <span class="online-dot"></span>
            </div>
            <div class="details">
                <span><?php echo htmlspecialchars($row['fname'] . " " . $row['lname'], ENT_QUOTES, 'UTF-8')?></span>
                <p><span class="status-indicator"></span><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8') ?></p>
            </div>
        </header>

        <div class="chat-box">
            <div class="chat incoming">
                
            </div>

            <div class="chat outgoing">
                
            </div>
        </div>

        <form action="#" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id ?>" hidden>
            <input type="text" name="message" class="input-field" placeholder="Digite uma mensagem..." autocomplete="off">
            <button type="submit" aria-label="Enviar mensagem"><i class="fab fa-telegram-plane"></i></button>
        </form>
    </section>
</div>

<script src="assets/js/chat.js"></script>

</body>


</html>
