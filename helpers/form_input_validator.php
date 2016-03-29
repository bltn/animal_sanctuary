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

}

?>
