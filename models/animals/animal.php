<?php

session_start();

class Animal {

    private $name;
    private $dob;
    private $description;
    private $picture_array;
    private $picture_location;

    public function __construct($name, $dob, $description, $picture_array) {
        $this->name = $name;
        $this->dob = $dob;
        $this->description = $description;
        $this->picture_array = $picture_array;
    }

    public static function list_user_animals($user_id) {
        require(__DIR__.'/../db_connection.php');
        try {
            $sanitised_user_id = $db->quote($user_id);
            $rows = $db->query("SELECT * from animal WHERE userID=$sanitised_user_id");
            return $rows;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = "There was an error retrieving the animals. Please refresh the page.<br>";
            return false;
        }
    }

    public static function search_for_animals($value) {
        require(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * FROM animal WHERE name LIKE '%$value%'");
            return $rows;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public static function list_all() {
        require(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from animal");
            $animals = array();
            foreach ($rows as $row) {
                $owner_id = $row['userID'];
                $owner = $db->query("SELECT * from user WHERE userID=$owner_id");
                $owner_details = $owner->fetch();
                $row['owner_email'] = $owner_details['email'];
                $row['owner_is_staff'] = $owner_details['staff'];
                $animals[] = $row;
            }
            return $animals;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = "There was an error retrieving the animals. Please refresh the page.<br>";
            return false;
        }
    }

    public static function list_all_pending() {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from adoptionRequest");
            $requests = array();
            foreach($rows as $row) {
                $animal_id = $row['animalID'];
                $animal = $db->query("SELECT * from animal WHERE animalID=$animal_id");
                $animal_details = $animal->fetch();
                $user_id = $animal_details['userID'];
                $user = $db->query("SELECT * from user WHERE userID=$user_id");
                $user_details = $user->fetch();
                if ($user_details['staff'] == 1) {
                    $row['animal_name'] = $animal_details['name'];
                    $requests[] = $row;
                }
            }
            return $requests;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            return false;
        }
    }

    public static function list_all_available() {
        require(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from animal WHERE available=true");
            return $rows;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = "There was an error retrieving the animals. Please refresh the page.<br>";
            return false;
        }
    }

    public static function find($id) {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $sanitised_id = $db->quote($id);
            $row = $db->query("SELECT * from animal where animalID=$sanitised_id");
            $user = $row->fetch();
            return $user;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = "There was an error retrieving the animal's details.<br>";
            header('Location: ../../views/animals/show_animal.php');
        }
    }

    public function save() {
        require_once(__DIR__.'/../db_connection.php');
        $saved = false;

        $imgWriteErrors = $this->saveImage($this->picture_array);
        if (count($imgWriteErrors) > 0) {
            foreach($imgWriteErrors as $error) {
                $_SESSION['error_message'] .= $error;
                return $saved; // false
            }
        } else {
            $sanitised_name = $db->quote($this->name);
            $sanitised_dob = $db->quote($this->dob);
            $sanitised_description = $db->quote($this->description);
            $user_id = $_SESSION['id'];
            try {
                $db->exec("INSERT INTO animal (name, dateOfBirth, description, photo, available, userID) VALUES ($sanitised_name, $sanitised_dob, $sanitised_description, '$this->picture_location', true, '$user_id')");
                $saved = true;
            } catch (PDOException $e) {
                $_SESSION['error_message'] = $e->getMessage();
            }
        }
        return $saved;
    }

    private function saveImage($picture) {
        $saveErrors = array();

        $name = $picture['name'];
        $type = $picture['type'];
        echo $type;
        if (($type == "image/jpeg")||($type == "image/png")||($type == "image/gif")) {
            move_uploaded_file($picture['tmp_name'], __DIR__.'/../../images/' . $name);
            $this->picture_location = '/animal_sanctuary/images/' . $name;
        } else {
            $saveErrors[] = "Wrong file type. Only jpeg, png and gif are allowed.<br>";
        }
        return $saveErrors;
    }
}
?>
