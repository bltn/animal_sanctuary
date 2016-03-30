<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User registration</title>
    </head>
    <body>
        <h1>Sign up</h1>
        <form action="../../config/router.php" method="post">
            Email address: <input type="email" name="email"><br>
            Password: <input type="password" name="password"><br>
            Password confirmation: <input type="password" name="password"><br>
            <input type="submit" name="sign_up">
        </form>

        <?php
        if (!empty($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];

            unset($_SESSION['error_message']);
            session_destroy();
        }
        ?>
    </body>
</html>
