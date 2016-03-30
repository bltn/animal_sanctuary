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

    public static function list_all() {
        require_once(__DIR__.'/../db_connection.php');
        try {
            $rows = $db->query("SELECT * from animal");
            return $rows;
        } catch (PDOEXception $e) {
            $_SESSION['error_message'] = "There was an error retrieving the animals. Please refresh the page.<br>";
            return false;
        }
    }

    public static function list_all_available() {
        require_once(__DIR__.'/../db_connection.php');
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
