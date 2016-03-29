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

    public function save() {
        require_once(__DIR__.'/../db_connection.php');
        $saved = false;

        if (empty($_SESSION['logged_in'])) {
            return $saved;
        } else {
            $imgWriteErrors = $this->saveImage($this->picture_array);
            if (count($imgWriteErrors) > 0) {
                foreach($imgWriteErrors as $err) {
                    echo $err;
                }
            } else {
                $sanitised_name = $db->quote($this->name);
                $sanitised_dob = $db->quote($this->dob);
                $sanitised_description = $db->quote($this->description);
                $user_id = $_SESSION['id'];
                try {
                    $db->exec("INSERT INTO animals (name, dateOfBirth, description, photo, available, userID) VALUES ($sanitised_name, $sanitised_dob, $sanitised_description, '$this->picture_location', '$user_id'");
                    $saved = true;
                } catch (PDOException $e) {
                    return $saved;
                }
            }
        }
        return $saved;
    }

    private function saveImage($picture) {
        $saveErrors = array();

        $name = $picture['name'];
        $type = $picture['type'];
        if (($type == "image/jpeg")||($type == "image/png")||($type == "image/gif")) {
            move_uploaded_file($picture['tmp_name'], __DIR__.'/../../images/' . $name);
            $this->picture_location = __DIR__.'/../../images/' . $name;
        } else {
            $saveErrors[] = "Wrong file type. Only jpeg, png and gif are allowed.<br>";
        }
        return $saveErrors;
    }
}
?>
