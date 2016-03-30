<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    session_destroy();
    header('Location: views/sessions/user_login.php');
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>All animals</title>
    </head>
    <body>
        <?php if (isset($_SESSION['id'])) {?> <a href='config/router.php?log_out'>Log out</a> <?php } ?>
    </body>
<html>
