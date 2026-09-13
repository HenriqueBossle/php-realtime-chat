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
            <header>Realtime chat app</header>
            <form action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name details">
                    <div class="field input">
                        <label for="fname">First name</label>
                        <input type="text" name="fname" id="fname" placeholder="First name" required>
                    </div>
                    <div class="field input">
                        <label for="lname">Last name</label>
                        <input type="text" name="lname" id="lname" placeholder="Last name" required>
                    </div>
                </div>
            
                <div class="field input">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" placeholder="Enter your email" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter new password" required>
                    <i ></i>
                </div>

                <div class="field image">
                    <label for="image">Profile Image</label>
                    <input type="file" name="image" id="image" accept="image/x-png,image/gif,image/jpeg,image/jpg"  required>
                </div>

                <div class="field button">
                    <input type="submit" name="submit" value="Continue to chat">
                </div>
            </form>

            <div class="link">Já tem conta? <a href="login.php">Entrar</a> </div>
        </section>
    </div>

    <script type="text/javascript" src="js/pass-show-hide.js"></script>
    <script type="text/javascript" src="js/signup.js"></script>
</body>
</html>