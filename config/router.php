<?php
session_start();
$_SESSION['error_message'] = "";
require_once(__DIR__.'/../helpers/form_input_validator.php');
require_once(__DIR__.'/../controllers/animal_controller.php');
require_once(__DIR__.'/../controllers/user_controller.php');
require_once(__DIR__.'/../controllers/adoption_request_controller.php');

if (isset($_POST['new_animal'])) {

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
} else if (isset($_POST['login'])) {
    $inputValidationErrors = FormInputValidator::validateUserLoginInput($_POST['email'], $_POST['password']);

    if (count($inputValidationErrors) > 0) {
        foreach ($inputValidationErrors as $error) {
            $_SESSION['error_message'] .= $error;
        }
        header('Location: ../views/sessions/user_login.php');
    } else {
        if (FormInputValidator::isStaffEmail($_POST['email'])) {
            $controller = new UserController();
            $controller->log_in_staff_user($_POST['email'], $_POST['password']);
        } else {
            $controller = new UserController();
            $controller->log_in_customer_user($_POST['email'], $_POST['password']);
        }
    }
} else if (isset($_GET['log_out'])) {
    $controller = new UserController();
    $controller->log_out();
} else if (isset($_POST['sign_up'])) {
    $inputValidationErrors = FormInputValidator::validateUserRegistrationInput($_POST['email'], $_POST['password'], $_POST['password_confirmation']);

    if (count($inputValidationErrors) > 0) {
        foreach ($inputValidationErrors as $error) {
            $_SESSION['error_message'] .= $error;
        }
        header('Location: ../views/sessions/user_registration.php');
    } else {
        $controller = new UserController();
        $controller->register_customer_user($_POST['email'], $_POST['password']);
    }
} else if (isset($_GET['request_adoption'])) {
    $controller = new AdoptionRequestController();
    $controller->create_adoption_request($_SESSION['id'], $_GET['animal_id']);
} else if (isset($_GET['process_adoption'])) {
    if ($_GET['approve'] == "false") {
        $controller = new AdoptionRequestController();
        $controller->deny_adoption_request($_GET['request_id']);
    } else {
        $controller = new AdoptionRequestController();
        $controller->approve_adoption_request($_GET['request_id']);
    }
} 
?>
