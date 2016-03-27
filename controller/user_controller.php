<?php

require('../model/db_connection.php');

if (isset($_POST['login'])) {
    // check for existence 
    // sanitise email, hash password (+ map this to the back-end)
    userExists($email, $password);
}

function userExists($email, $password) {
    $row = $db->query("select * from staff where email=$email AND password=$password");
    // check size of row
    // if zero (no user), return false
    // else return true 
}

?>