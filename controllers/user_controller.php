<?php

class UserController {

    public function __construct() {}

    public function log_in_staff_user($email, $password) {
        if (!isset($_SESSION['id'])) {
            require_once(__DIR__."/../models/users/staff_user.php");
            session_start();
            $user_exists = false;
            $_SESSION['error_message'] = "";
            try {
                $user_exists = StaffUser::exists($email, $password);
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
        } else {
            $_SESSION['error_message'] = "You're already logged in, silly.<br>";
            header('Location: ../index.php');
        }
    }

    public function register_customer_user($email, $password) {
        require_once(__DIR__."/../models/users/customer_user.php");
        $_SESSION['error_message'] = "";
        try {
            $clashes = CustomerUser::exists($email, $password);
        } catch (PDOException $e) {
            $_SESSION['error_message'] .= "We encountered an error querying the database. Try again later.<br>";
            header('Location: ../views/sessions/user_registration.php');
        }

        if (empty($clashes)) {
            $user = new CustomerUser($email, $password);
            if ($user->save()) {
                $user->log_in();
                header('Location: ../index.php');
            } else {
                $_SESSION['error_message'] = "There was an issue with the registration process. Please try again.<br>";
                header('Location: ../views/sessions/user_registration.php');
            }
        } else {
            foreach ($clashes as $clash_message) {
                $_SESSION['error_message'] .= $clash_message . "<br>";
            }
            header('Location: ../views/sessions/user_registration.php');
        }
    }

    public function log_out() {
        session_start();
        session_destroy();
        header('Location: ../views/sessions/user_login.php');
    }
}
?>
