<html>
<head>
    <link rel="stylesheet" type="text/css" href="/animal_sanctuary/views/stylesheets/style.css">
    <meta charset="utf-8">
    <title>All animals</title>
</head>
<body>
<?php
session_start();
include('../layouts/header.php');
require_once(__DIR__.'/../../controllers/animal_controller.php');
$animal_controller = new AnimalController();
$animal_list = $animal_controller->index();
if(!isset($_SESSION['id'])) {
    header('Location: ../sessions/user_login.php');
} else {
    if ($_SESSION['staff'] == false) {
        echo "<strong>Non-staff users can't view this page</strong>";
    } else {
?>
<table>
    <tr>
        <th>Name</th>
        <th>Age</th>
        <th>Owner email</th>
        <th>Photo</th>
        <th>Link</th>
    </tr>
<?php
if (!empty($animal_list)) {
    foreach($animal_list as $animal) {
        if ($animal['owner_is_staff'] == true) {
            $owner_status = "(staff)";
        } else {
            $owner_status = "(customer)";
        }
        echo "<tr>";
        echo "<th>" . $animal['name'] . "</th>";
        echo "<th>" . date_diff(date_create($animal['dateOfBirth']), date_create('today'))->y . " years old" . "</th>";
        echo "<th>" . $animal['owner_email'] . " " . $owner_status . " " . "</th>";
        echo "<th> <img src=\"" . $animal['photo'] . "\" height=\"70\" width=\"70\"></th>";
        echo "<th> <a href='show_animal.php?id=" . $animal['animalID'] . "'>Details</a></th>";
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
}
}
?>
</body>
</html>
