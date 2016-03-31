<?php
session_start();
require_once(__DIR__.'/../../controllers/animal_controller.php');
$animal_controller = new AnimalController();

$animal_list = $animal_controller->index();
?>
<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Photo</th>
        <th>Link</th>
    </tr>
<?php
if (!empty($animal_list)) {
    foreach($animal_list as $animal) {
        echo "<tr>";
        echo "<th>" . $animal['name'] . "</th>";
        echo "<th>" . date_diff(date_create($animal['dateOfBirth']), date_create('today'))->y . " years old" . "</th>";
        echo "<th> <img src=\"" . $animal['photo'] . "\" height=\"70\" width=\"70\"></th>";
        echo "<th> <a href='/animal_sanctuary/views/animals/show_animal.php?id=" . $animal['animalID'] . "'>Details</a></th>";
        echo "</tr>";
    }
}
?>
</table>
<?php
if (!empty($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
