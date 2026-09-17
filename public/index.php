<?php 

    session_start();

    if(isset($_SESSION['unique_id'])){
        header("location: users.php");
        exit;
    }

?>

<?php include_once "header.php"; ?>

<body>
    
    <div class="wrapper">
        <section class="form signup">
            <header>Criar <span>conta</span></header>
            <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name details">
                    <div class="field input">
                        <label for="fname">Nome</label>
                        <input type="text" name="fname" id="fname" placeholder="João" required>
                    </div>
                    <div class="field input">
                        <label for="lname">Sobrenome</label>
                        <input type="text" name="lname" id="lname" placeholder="Silva" required>
                    </div>
                </div>
            
                <div class="field input">
                    <label for="email">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="seuemail@exemplo.com" required>
                </div>

                <div class="field input">
                    <label for="password">Senha</label>
                    <input type="password" name="password" id="password" placeholder="Crie uma senha segura" required>
                    <i></i>
                </div>

                <div class="field image">
                    <label for="image">Foto de perfil</label>
                    <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>

                <div class="field button">
                    <input type="submit" name="submit" value="Criar conta e entrar">
                </div>
            </form>

            <div class="link">Já tem uma conta? <a href="login.php">Entrar agora</a></div>
        </section>
    </div>

    <script type="text/javascript" src="assets/js/pass-show-hide.js"></script>
    <script type="text/javascript" src="assets/js/signup.js"></script>
</body>
</html>