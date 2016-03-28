<?php

session_start();

if(!isset($_SESSION['logged_in'])) {
    header('Location: user_login.php');
}

if (!empty($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];

    unset($_SESSION['error_message']);
}

?>
