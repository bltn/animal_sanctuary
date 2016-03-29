<?php
require_once(__DIR__.'/../helpers/form_input_validator.php');
require_once(__DIR__.'/../models/animals/animal.php');
session_start();

$_SESSION['error_message'] = "";

if (!isset($_SESSION['logged_in'])) {
    $_SESSION['error_message'] = "You need to be logged in to create an animal.<br>";
    header('Location: ../../views/sessions/user_login.php');
} else {
    newAnimal();
}

function newAnimal() {

    $inputValidationErrors = FormInputValidator::validateNewAnimalInput($_POST['name'], $_POST['dob'], $_POST['description'], $_FILES['picture']['error']);

    if (count($inputValidationErrors) > 0) {
        foreach ($inputValidationErrors as $error) {
            $_SESSION['error_message'] .= $error;
        }
        header('Location: ../views/animals/add_animal.php');
    } else {
        $animal = new Animal($_POST['name'], $_POST['dob'], $_POST['description'], $_FILES['picture']);
        if ($animal->save()) {
            header('Location: ../index.php');
        } else {
            header('Location: ../views/animals/add_animal.php');
        }
    }
}
?>
