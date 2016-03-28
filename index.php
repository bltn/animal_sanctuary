<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    header('Location: views/user_login.php');
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>All animals</title>
    </head>
    <body>
        <?php if (isset($_SESSION['logged_in'])) {?> <a href='controllers/user_controller.php'>Log out</a> <?php } ?>
    </body>
<html>
