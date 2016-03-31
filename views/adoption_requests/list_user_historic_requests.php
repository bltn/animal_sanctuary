<html>
<head>
    <title>Historic adoption requests</title>
    <link rel="stylesheet" type="text/css" href="/animal_sanctuary/views/stylesheets/style.css">
    <meta charset="utf-8">
</head>
<body>
    <?php
    session_start();
    include('../layouts/header.php');
    require_once(__DIR__.'/../../controllers/adoption_request_controller.php');
    $request_controller = new AdoptionRequestController();
    if (isset($_SESSION['id'])) {
        if ($_SESSION['staff'] == true) {
            echo "You need to be a customer user.";
        } else {
            $request_list = $request_controller->closed_user_index($_SESSION['id']);
        }
    } else {
        header('Location: ../sessions/user_login.php');
    }
    ?>
    <table>
    <tr>
        <th>Animal name</th>
        <th>Status</th>
    </tr>
    <?php
    if (!empty($request_list)) {
        foreach($request_list as $request) {
            echo "<tr>";
            echo "<td> <a href='../animals/show_animal.php?id=" . $request['animalID'] . "'>" . $request['animal_name'] . "</a></td>";
            if ($request['approved'] == 1) {
                echo "<td>Approved</td>";
            } else {
                echo "<td>Denied</td>";
            }
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
</body>
</html>
