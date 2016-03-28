<?php session_start(); ?>
<html>
    <head>
        <title>Add a new animal</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['logged_in'])) {
        ?>
        <form action="../controllers/animal_controller.php" method="post" id="add_animal_form">
            Animal's name: <input type="text" name="name"><br>
            Animal's DOB: <input type="date" name="dob"><br>
            Desc: <textarea name="description" form="add_animal_form">Tell us about the animal...</textarea><br>
            Picture: <input type="file" name="picture"><br>
            <input type="submit" name="new_animal">
        </form>
        <?php
        } else {
            $_SESSION['error_message'] = "Please log in before trying to add animal.<br>";
            header('Location: user_login.php');
        }
        ?>
    </body>
</html>
