<?php

session_start();

if (isset($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];

    unset($_SESSION['error_message']);
}
?>
