<?php

//require_once('../model/db_connection.php');

if (isset($_POST['login'])) {
    
    // check for existence 
    // sanitise email, hash password (+ map this to the back-end)
    $db = new PDO("mysql:host=localhost;dbname=animal_sanctuary", "cwk", "8G9vRCwzDdESFaJA");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $exists = userExists($_POST['email'], $_POST['password'], $db);

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