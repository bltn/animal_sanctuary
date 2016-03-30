<?php
class AnimalController {

    public function __construct() {}

    public function new_animal($name, $dob, $description, $picture) {
        require_once(__DIR__.'/../models/animals/animal.php');

        $animal = new Animal($name, $dob, $description, $picture);
        if ($animal->save()) {
            header('Location: ../index.php');
        } else {
            header('Location: ../views/animals/add_animal.php');
        }
    }
}
?>
