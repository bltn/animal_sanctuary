<?php
session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Staff log in page</title>
    </head>
    <body>
        <h1>Log in (staff)</h1>
        <form action="controller/user_controller.php" method="post">
            Staff email: <input type="email" name="email"><br>
            Password: <input type="password" name="password"><br>
            <input type="submit" name="login">
        </form>

        <?php
        if (isset($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];

            unset($_SESSION['error_message']);
        }
        ?>
    </body>
</html>
