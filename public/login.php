<?php 

    session_start();
    if(isset($_SESSION['unique_id'])){
        header("location: users.php");
    }

?>

<?php include_once "header.php"; ?>

<body>
    <div class="wrapper">
        <section class="form login">
            <header>Bem-vindo <span>de volta</span></header>
            <form action="#" method="post" autocomplete="off">
                <div class="error text"></div>
                <div class="field input">
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="seuemail@exemplo.com" required>
                </div>

                <div class="field input">
                    <label>Senha</label>
                    <input type="password" name="password" placeholder="Sua senha" required>
                    <i class="fas fa-eye"></i>
                </div>

                <div class="field button">
                    <input type="submit" name="submit" value="Entrar no chat">
                </div>
            </form>

            <div class="link">Ainda não tem conta? <a href="index.php">Cadastrar agora</a></div>
        </section>
    </div>

    <script type="text/javascript" src="assets/js/pass-show-hide.js"></script>
    <script type="text/javascript" src="assets/js/login.js"></script>
</body>
</html>