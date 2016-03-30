<?php session_start();
require_once(__DIR__.'/../../controllers/animal_controller.php');

$animal_controller = new AnimalController();
?>
<html>
    <head>
        <title>Animal details!</title>
    </head>
    <body>
        <?php
        $animal = $animal_controller->show($_GET['id']);
        ?>
        <table>
            <tr>
                <th>Name</th>
                <th>Date of birth</th>
                <th>Age</th>
                <th>Photo</th>
                <th>Description</th>
            </tr>
            <?php
            if ($animal) {
                echo "<tr>";
                echo "<th>" . $animal['name'] . "</th>";
                echo "<th>" . $animal['dateOfBirth'] . "</th>";
                echo "<th>" . date_diff(date_create($animal['dateOfBirth']), date_create('today'))->y . " years old" . "</th>";
                echo "<th> <img src=\"" . $animal['photo'] . "\" height=\"70\" width=\"70\"></th>";
                echo "<th>" . $animal['description'] . "</th>";
                echo "</tr>";
            }
            ?>
        </table>
        <?php
        if ($_SESSION['staff'] == false) {
            echo "<a href=\"../../config/router.php?request_adoption&animal_id=" . $_GET['id'] . "\">Request adoption</a><br>";
        }
        ?>
        <a href='list_animals.php'>Back</a>
        <?php
        if (!empty($_SESSION['error_message'])) {
            echo $_SESSION['error_message'];
            unset($_SESSION['error_message']);
        }
        ?>
    </body>
</html>
