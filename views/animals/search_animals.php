<html>
<head>
    <title>Animals</title>
    <link rel="stylesheet" type="text/css" href="/animal_sanctuary/views/stylesheets/style.css">
    <meta charset="utf-8">
</head>
<body>
<?php
session_start();
require(__DIR__.'/../../controllers/animal_controller.php');
$controller = new AnimalController();
include('../layouts/header.php');
?>
<?php
$animal_list = $controller->search_for_animals($_POST['animalsearch']);
if (!empty($animal_list)) {
?>
<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Photo</th>
        <th>Link</th>
    </tr>
<?php
    foreach($animal_list as $animal) {
        echo "<tr>";
        echo "<th>" . $animal['name'] . "</th>";
        echo "<th>" . date_diff(date_create($animal['dateOfBirth']), date_create('today'))->y . " years old" . "</th>";
        echo "<th> <img src=\"" . $animal['photo'] . "\" height=\"70\" width=\"70\"></th>";
        echo "<th> <a href='show_animal.php?id=" . $animal['animalID'] . "'>Details</a></th>";
        echo "</tr>";
    }
} else {
    echo "No animals found.";
}
?>
</table>
<?php
if (!empty($_SESSION['error_message'])) {
    echo $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>
