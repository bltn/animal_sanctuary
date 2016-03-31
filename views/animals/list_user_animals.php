<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Photo</th>
        <th>Link</th>
    </tr>
<?php
session_start();
require(__DIR__.'/../../controllers/animal_controller.php');
$controller = new AnimalController();
$animal_list = $controller->list_user_animals($_SESSION['id']);
if (!empty($animal_list)) {
    foreach($animal_list as $animal) {
        echo "<tr>";
        echo "<th>" . $animal['name'] . "</th>";
        echo "<th>" . date_diff(date_create($animal['dateOfBirth']), date_create('today'))->y . " years old" . "</th>";
        echo "<th> <img src=\"" . $animal['photo'] . "\" height=\"70\" width=\"70\"></th>";
        echo "<th> <a href='show_animal.php?id=" . $animal['animalID'] . "'>Details</a></th>";
        echo "</tr>";
    }
} else {
    echo "You have no animals";
}
?>
</table>
<?php
if (!empty($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
