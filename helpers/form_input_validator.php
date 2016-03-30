<?php

class FormInputValidator {

    public static function validateNewAnimalInput($name, $dob, $description, $picture_error_code) {
        $errors = array();

        if (empty($name)) {
            $errors[] =  "You need to provide a valid name.<br>";
        }
        if (empty($dob)) {
            $errors[] = "You need to provide a valid date of birth.<br>";
        }
        if (empty($description)) {
            $errors[] = "You need to provide a valid description for the animal (likes, dislikes, etc).<br>";
        }
        if ($picture_error_code == 4) {
            $errors[] = "You have to provide an image of the animal.<br>";
        } else if ($picture_error_code > 0) {
            $errors[] = "There was an error uploading the image. Please try again.<br>";
        }

        return $errors;
    }

    public static function validateUserLoginInput($email, $password) {
        $errors = array();

        if (empty($email)) {
            $errors[] = "You need to provide an email address to log in.<br>";
        }
        if (empty($password)) {
            $errors[] = "You need to enter a password to log in.<br>";
        }
        return $errors;
    }

    public static function isStaffEmail($email) {
        require(__DIR__.'/../models/db_connection.php');
        try {
            $sanitised_email = $db->quote($email);
            $row = $db->query("select * from user where email=$sanitised_email");
            $user = $row->fetch();
            if ($user['staff'] == 1) {
                $is_staff = true;
            } else {
                $is_staff = false;
            }
            return $is_staff;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function validateUserRegistrationInput($email, $password, $password_confirmation) {
        $errors = array();

        if (empty($email)) {
            $errors[] = "Please provide a valid email address.<br>";
        }
        if (empty($password)) {
            $errors[] = "Please provide a password for your account.<br>";
        }
        if (empty($password_confirmation)) {
            $errors[] = "Please confirm the password you'd like to use for your account.<br>";
        }
        if (strcmp($password, $password_confirmation) != 0) {
            $errors[] = "Your password and confirmation don't match.<br>";
        }
        return $errors;
    }

}

?>
