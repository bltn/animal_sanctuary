<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User registration</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['id'])) {
            echo "<h2>You're logged in under " . $_SESSION['email'] . ".</h2>";
            echo "You can't register for an account whilst you're signed into another. Click <a href='../../config/router.php?log_out'>here</a> if you'd like to log out.";
        } else {
        ?>
        <h1>Sign up</h1>
        <form action="../../config/router.php" method="post">
            Email address: <input type="email" name="email"><br>
            Password: <input type="password" name="password"><br>
            Password confirmation: <input type="password" name="password_confirmation"><br>
            <input type="submit" name="sign_up">
        </form>
        <?php } ?>
        <?php
        if (!empty($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }
        ?>
    </body>
</html>
