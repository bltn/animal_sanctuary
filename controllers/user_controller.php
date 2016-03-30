<?php

class UserController {

    public function __construct() {}

    public function log_in_staff_user($email, $password) {
        require_once(__DIR__."/../models/users/user.php");
        session_start();

        $user_exists = false;

        $_SESSION['error_message'] = "";

        try {
            $user_exists = StaffUser::exists($_POST['email'], $_POST['password']);
        } catch (PDOException $e) {
            $_SESSION['error_message'] .= "We encountered an error querying the database. Try again later.<br>";
            header('Location: ../views/sessions/user_login.php');
        }

        if ($user_exists) {
            try {
                StaffUser::logInUser($_POST['email']);
                header('Location: ../index.php');
            } catch (PDOException $e) {
                $_SESSION['error_message'] .= "We encountered an error logging you in. Try again.<br>";
                header('Location: ../views/sessions/user_login.php');
            }
        } else {
            $_SESSION['error_message'] .= "We couldn't find you in the system. Please double check your email and password for spelling.<br>";
            header('Location: ../views/sessions/user_login.php');
        }
    }

    public function log_out() {
        session_start();
        session_destroy();
        header('Location: ../views/sessions/user_login.php');
    }
}
?>
