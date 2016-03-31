<?php session_start();
require_once(__DIR__.'/../../controllers/adoption_request_controller.php');
$request_controller = new AdoptionRequestController();
if (isset($_SESSION['id'])) {
    if ($_SESSION['staff'] == false) {
        echo "You need to be a staff user.";
    } else {
        $request_list = $request_controller->closed_index();
    }
} else {
    header('Location: ../sessions/user_login.php');
}
?>
<table>
<tr>
    <th>Animal name</th>
    <th>Status</th>
    <th>Owner email</th>
</tr>
<?php
if (!empty($request_list)) {
    foreach($request_list as $request) {
        echo "<tr>";
        echo "<td> <a href='../animals/show_animal.php?id=" . $request['animalID'] . "'>" . $request['animal_name'] . "</a></td>";
        if ($request['owner_is_staff'] == true) {
            $owner_status = "(staff)";
        } else {
            $owner_status = "(customer)";
        }
        if ($request['approved'] == 1) {
            echo "<td>Approved</td>";
        } else {
            var_dump($request['approved']);
            echo "<td>Denied</td>";
        }
        echo "<td>" . $request['owner_email'] . " " . $owner_status . " " . "</td>";
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
