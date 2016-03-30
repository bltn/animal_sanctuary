<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Log in page</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['id'])) {
            echo "<h2>You're already logged in under " . $_SESSION['email'] . "!</h2><br>";
            echo "Click <a href='../../config/router.php?log_out'>here</a> to log out.";
        } else {
        ?>
        <h1>Log in</h1>
        <form action="../../config/router.php" method="post">
            Staff email: <input type="email" name="email"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" name="login">
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
