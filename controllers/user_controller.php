<?php

require_once("../models/user.php");

if (isset($_POST['login'])) {

    session_start();

    if (newSession()) {
        header('Location: ../index.php');
    } else {
        $_SESSION['error_message'] .= "We couldn't find an account with the given username and/or password. Please try again.<br>";
        header('Location: ../user_login.php');
    }
} else {
    session_start();
    session_destroy();
    header('Location: ../user_login.php');
}

function newSession() {
    $signed_in = false;
    $user_exists = false;

    $_SESSION['error_message'] = "";

    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        try {
            $user_exists = StaffUser::exists($_POST['email'], $_POST['password']);
        } catch (PDOException $e) {
            $_SESSION['error_message'] .= $e->getMessage();
        }
    } else {
        $_SESSION['error_message'] .= "Please provide a valid username and password.<br>";
    }

    if ($user_exists) {
        StaffUser::logInUser($_POST['email']);
        $signed_in = true;
    }

    return $signed_in;
}

?>
