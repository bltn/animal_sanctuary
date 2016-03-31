<?php
session_start();

if(!isset($_SESSION['logged_in'])) {
    session_destroy();
    header('Location: views/sessions/user_login.php');
}
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/animal_sanctuary/views/stylesheets/style.css">
        <meta charset="utf-8">
        <title>All animals</title>
    </head>
    <body>
        <?php
        include('views/layouts/header.php');
        if ($_SESSION['staff'] == 1) {
            echo "<h1>Pending adoption requests</h1>";
            include('views/adoption_requests/list_pending_requests.php');
            echo "<h1>Animals available for adoption<h1>";
            include('views/animals/list_available_animals.php');
        }
        ?>
    </body>
<html>
