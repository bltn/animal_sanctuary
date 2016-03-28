<?php

//require_once('../model/db_connection.php');

if (isset($_POST['login'])) {

    session_start();

    // sanitise email, hash password (+ map this to the back-end)
    $db = new PDO("mysql:host=localhost;dbname=animal_sanctuary", "cwk", "8G9vRCwzDdESFaJA");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $safe_email = null;
    $safe_hashed_password = null;

    $error_triggered = false;

    if (!empty($_POST['email'])) {
        $safe_email = $db->quote($_POST['email']);
    } else {
        $_SESSION['error_message'] .= "Error: you need to provide a valid email address.<br>";
        $error_triggered = true;
    }

    if (!empty($_POST['password'])) {
        $safe_hashed_password = md5($db->quote($_POST['password']));
    } else {
        $_SESSION['error_message'] .= "Error: you need to provide a valid password.<br>";
        $error_triggered = true;
    }

    if ($error_triggered) {
        header('Location: ../user_login.php');
    }

    $exists = userExists($safe_email, $safe_hashed_password, $db);

    if ($exists) {
        // redirect to the staff pet listing
    } else {
        // stay on log in page, echo error stmt
    }
}

function userExists($email, $password, $db) {
    try {
        $row = $db->query("select * from user where email=$email AND password=$password");
    } catch (Exception $e) {
        // handle
    }
    // check size of row
    // if zero (no user), return false
    // else return true
    echo "DONE";
}

?>
