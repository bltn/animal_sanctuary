<?php
session_start();
require_once(__DIR__.'/../../controllers/adoption_request_controller.php');
$request_controller = new AdoptionRequestController();
if (isset($_SESSION['id'])) {
    if ($_SESSION['staff'] == true) {
        echo "You need to be a customer user.";
    } else {
        $request_list = $request_controller->user_pending_index($_SESSION['id']);
    }
} else {
    header('Location: ../sessions/user_login.php');
}
?>
<table>
<tr>
    <th>Animal name</th>
    <th>Animal link</th>
</tr>
<?php
if (!empty($request_list)) {
    foreach($request_list as $request) {
        echo "<tr>";
        echo "<td> <a href='../animals/show_animal.php?id=" . $request['animalID'] . "'>" . $request['animal_name'] . "</a></td>";
        echo "<td> <a href='../animals/show_animal.php?id=" . $request['animalID'] . "'>Animal details</a></td>";
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
