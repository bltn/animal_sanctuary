<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    header('Location: user_login.php');
}
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>All animals</title>
    </head>
    <body>
        <?php if (isset($_SESSION['logged_in'])) {?> <a href='#'>Log out</a> <?php } ?>
    </body>
<html>
