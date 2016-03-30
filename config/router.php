<?php
session_start();
$_SESSION['error_message'] = "";
require_once(__DIR__.'/../helpers/form_input_validator.php');
require_once(__DIR__.'/../controllers/animal_controller.php');

if ($_POST['new_animal']) {

    $inputValidationErrors = FormInputValidator::validateNewAnimalInput($_POST['name'], $_POST['dob'], $_POST['description'], $_FILES['picture']['error']);

    if (count($inputValidationErrors) > 0) {
        foreach ($inputValidationErrors as $error) {
            $_SESSION['error_message'] .= $error;
        }
        header('Location: ../views/animals/add_animal.php');
    } else {
        $controller = new AnimalController();
        $controller->new_animal($_POST['name'], $_POST['dob'], $_POST['description'], $_FILES['picture']);
    }
}
?>
