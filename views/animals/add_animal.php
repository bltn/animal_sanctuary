<?php session_start(); ?>
<html>
    <head>
        <title>Add a new animal</title>
    </head>
    <body>
        <?php
        if (isset($_SESSION['id']) && $_SESSION['staff'] == true) {
        ?>
        <form action="../../config/router.php" method="post" id="add_animal_form" enctype="multipart/form-data">
            Animal's name: <input type="text" name="name"><br>
            Animal's DOB: <input type="date" name="dob"><br>
            Desc: <textarea name="description" form="add_animal_form" placeholder="Tell us about the animal..."></textarea><br>
            Picture: <input type="file" name="picture"><br>
            <input type="submit" name="new_animal">
        </form>
        <?php
        if (!empty($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }
        ?>
        <?php
        } else if (isset($_SESSION['id']) && $_SESSION['staff'] == false) {
            echo "<strong>Non-staff users can't add animals to the directory.</strong>";
        } else {
            $_SESSION['error_message'] = "Please log in before trying to add animal.<br>";
            header('Location: ../sessions/user_login.php');
        }
        ?>
    </body>
</html>
