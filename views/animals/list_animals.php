<?php session_start();
require_once(__DIR__.'/../../controllers/animal_controller.php');
$animal_controller = new AnimalController();
?>
<html>
    <head>
        <title>Animal listing!</title>
    </head>
    <body>
        <?php
        $animal_list = $animal_controller->index();
        ?>
        <ul>
            <?php
            if (!empty($animal_list)) {
                foreach($animal_list as $animal) {
                    echo "<li>" . $animal['name'] . ", " . $animal['dateOfBirth'] . "</li>";
                }
            }
            ?>
        </ul>
        <?php
        if (!empty($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }
        ?>
    </body>
</html>
